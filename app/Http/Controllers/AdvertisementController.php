<?php

namespace App\Http\Controllers;

use App\Http\Request\AdvertisementRequest;
use App\Models\Advertisement;
use App\Models\Category;

//use App\Models\Cities;
use App\Models\City;
use App\Services\AdvertisementService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use phpDocumentor\Reflection\Location;

class AdvertisementController extends Controller
{


    protected $service;

    public function __construct(AdvertisementService $service)
    {
        $this->service = $service;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function create()
    {
        $categories = Category::where(['status' => 1])->get();
        $cities = City::all();
        return view('pages.advertisement.create', [
            'categories' => $categories,
            'cities' => $cities
        ]);
    }

    public function store(AdvertisementRequest $request)
    {
        if (!$this->service->store($request)) {
            return redirect(route('home'))->with('danger', 'Advertisement does not create.');
        }
        return redirect(route('home', app()->getLocale()))->with('success', 'Advertisement was successfully created.');

    }
}
