<?php

namespace App\Http\Controllers;

use App\Http\Request\AdvertisementRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

    }

    public function create(){
        $categories = Category::where(['status' => 1])->get();
        return view('pages.advertisement.create', [
            'categories' => $categories
        ]);
    }

    public function store(AdvertisementRequest $request){

        dd($request);
    }
}
