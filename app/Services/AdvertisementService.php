<?php

namespace App\Services;

use App\Http\Request\Admin\AnswerRequest;
use App\Http\Request\Admin\CategoryRequest;
use App\Http\Request\AdvertisementRequest;
use App\Models\Advertisement;
use App\Models\Answer;
use App\Models\AnswerLanguage;
use App\Models\Category;
use App\Models\City;
use App\Models\Feature;
use App\Models\FeatureAnswers;
use App\Models\FeatureLanguage;
use App\Models\Localization;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\throwException;

class AdvertisementService
{
    protected $model;

    protected $perPageArray = [10, 20, 30, 50, 100];

    public function __construct(Advertisement $model)
    {
        $this->model = $model;
    }

    /**
     * Get Feature by id.
     *
     * @param int $id
     * @return Advertisement
     */
    public function find(int $id)
    {
        return $this->model->where('id', $id)->firstOrFail();
    }

    /**
     * Get Features.
     *
     * @param string $lang
     * @return LengthAwarePaginator
     * @throws \Exception
     */
    public function getAll(string $lang, $request)
    {
        $data = $this->model->query();


        if ($request->feature !== null) {
            $modelarray = FeatureAnswers::select('answer_id')->where('feature_id', intval($request->all()['feature']))->get()->toArray();
            $data = $data->whereIn('id', $modelarray);
        }
        if ($request->position !== null) {
            $data = $data->where('position', 'like', '%' . $request->all()['position'] . '%');
        }
        if ($request->slug !== null) {
            $data = $data->where('slug', 'like', '%' . $request->all()['slug'] . '%');
        }
        if ($request->title !== null) {
            $modelarray = AnswerLanguage::select('answer_id')->where('title', 'like', '%' . $request->all()['title'] . '%')->get()->toArray();
            $data = $data->whereIn('id', $modelarray);
        }
        if ($request->status !== null) {
            $data = $data->where('status', 'like', '%' . $request->all()['status'] . '%');
        }

        // Check if perPage exist and validation by perPageArray [].
        $perPage = ($request->per_page != null && in_array($request->per_page, $this->perPageArray)) ? $request->per_page : 10;

        return $data->orderBy('id', 'DESC')->paginate($perPage);
    }


    /**
     * Create Feature item into db.
     *
     * @param string $lang
     * @param array $request
     * @return bool
     */
    public function store(AdvertisementRequest $request)
    {

        $category = Category::where(['id' => $request['category']])->first();
        $city = City::where(['id' => $request['city']])->first();
        $schedule = null;
        $experience = null;

        switch ($request['work_schedule']) {
            case "part_time":
                $schedule = $this->model::PART_TIME;
                break;
            case "full_time":
                $schedule = $this->model::FULL_TIME;
                break;
            case "remote":
                $schedule = $this->model::REMOTE;
                break;
        }

        switch ($request['experience']) {
            case "without_experience":
                $experience = $this->model::WITHOUT_EXPERIENCE;
                break;
            case "less_than_one_year":
                $experience = $this->model::LESS_THAN_ONE_YEAR;
                break;
            case "one_three_year":
                $experience = $this->model::ONE_THREE_YEAR;
                break;
            case "three_five_year":
                $experience = $this->model::THREE_FIVE_YEAR;
                break;
            case "five_ten_year":
                $experience = $this->model::FIVE_TEN_YEAR;
                break;
            case "more_than_ten_year":
                $experience = $this->model::MORE_THAN_TEN_YEAR;
                break;
        }


        if ($category && $city && $schedule && $experience) {
            $model = $this->model->create([
                'category_id' => $category->id,
                'city_id' => $city->id,
                'work_schedule' => $schedule,
                'experience' => $experience,
                'title' => $request['title'],
                'description' => $request['description'],
                'duties' => $request['duties'],
                'requirements' => $request['requirements'],
                'salary_type' => $request['salary_type'],
                'salary_amount' => $request['salary'],
                'phone' => $request['phone'],
                'email' => $request['email']
            ]);

            if ($model) {
                return true;
            }
            return false;
        }
        return false;

    }

    /**
     * Update Feature item.
     *
     * @param int $id
     * @param AnswerRequest $request
     * @return bool
     */
    public function update(int $id, string $lang, AnswerRequest $request)
    {
        $feature = Feature::findOrFail(intval($request['feature']));
        $model = Answer::findOrFail(intval($id));
        $localization = $this->getLocalization($lang);
        $model->update([
            'slug' => $request['slug'],
            'position' => $request['position'],
            'status' => intval($request['status']),
        ]);

        $language = $model->language()->where('language_id', $localization->id)->first();
        if ($language) {
            $language->title = $request['title'];
            $language->save();
        } else {
            $model->language()->create([
                'language_id' => $localization->id,
                'title' => $request['title']
            ]);
        }
        if (count($model->files) > 0) {
            foreach ($model->files as $file) {
                if ($request['old_images'] == null) {
                    $file->delete();
                    continue;
                }
                if (!in_array($file->id, $request['old_images'])) {
                    if (Storage::exists('public/answer/' . $model->id . '/' . $file->name)) {
                        Storage::delete('public/answer/' . $model->id . '/' . $file->name);
                    }
                    $file->delete();

                }
            }
        }


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                $imagename = date('Ymhs') . $file->getClientOriginalName();
                $destination = base_path() . '/storage/app/public/answer/' . $model->id;
                $request->file('images')[$key]->move($destination, $imagename);
                $model->files()->create([
                    'name' => $imagename,
                    'path' => '/storage/app/public/answer/' . $model->id,
                    'format' => $file->getClientOriginalExtension(),
                ]);
            }
        }


        $model->feature()->update([
            'feature_id' => $feature->id
        ]);
        return true;
    }

    /**
     * Create localization item into db.
     *
     * @param int $id
     * @return boolean
     * @throws \Exception
     */
    public function delete($id)
    {
        $data = $this->model->find($id);
        if (!$data->language()->delete()) {
            throwException('Feature languages can not delete.');
        }
        if (!$data->delete()) {
            throwException('Feature  can not delete.');
        }
        if (count($data->files) > 0) {
            if (Storage::exists('public/answer/' . $data->id)) {
                Storage::deleteDirectory('public/answer/' . $data->id);
            }
            $data->files()->delete();
        }

        return true;
    }

    /**
     * Create localization item into db.
     *
     * @param string $lang
     * @return Localization
     * @throws \Exception
     */
    protected function getLocalization(string $lang)
    {
        $localization = Localization::where('abbreviation', $lang)->first();
        if (!$localization) {
            throwException('Localization not exist.');
        }

        return $localization;
    }
}
