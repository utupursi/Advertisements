<?php
/**
 *  app/Http/Request/Admin/LocalizationRequest.php
 *
 * User:
 * Date-Time: 15.12.20
 * Time: 14:09
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Http\Request;

use App\Models\Language;
use App\Models\Localization;
use Illuminate\Foundation\Http\FormRequest;

class AdvertisementRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'city' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'work_schedule' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'string|max:1024|nullable',
            'duties' => 'string|max:1024|nullable',
            'requirements' => 'string|max:255|nullable',
//            'salary_type' => 'string|max:255|nullable',
            'salary' => 'numeric|nullable',
            'phone' => 'string|max:255|nullable',
            'email' => 'email|max:255|nullable',
        ];

        return $rules;

    }
}
