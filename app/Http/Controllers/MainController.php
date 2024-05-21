<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\City;


class MainController extends Controller
{
    public function index($city = null) {
        $cities = City::all()->sortBy('name');

        if($city == null && Session::has('selectedCitySlug')) {
            $city = Session::get('selectedCitySlug');
        }

        if($city != null) {
            $model = City::where('slug', $city)->first();
            Session::forget('selectedCitySlug');
            Session::forget('selectedCityName');
            Session::put('selectedCitySlug', $city);    
            Session::put('selectedCityName', $model->name);
        }

        return view('index', ['cities' => $cities]);
    }

    public function about($city = null) {
        if($city == null && Session::has('selectedCitySlug')) {
            $city = Session::get('selectedCitySlug');
        }

        if($city != null && $city != Session::get('selectedCitySlug')) {
            $model = City::where('slug', $city)->first();
            Session::forget('selectedCitySlug');
            Session::forget('selectedCityName');
            Session::put('selectedCitySlug', $city);
            Session::put('selectedCityName', $model->name);

            return redirect('/'.$city.'/about');
        }
        return view('about');
    }

    public function news($city = null) {
        if($city == null && Session::has('selectedCitySlug')) {
            $city = Session::get('selectedCitySlug');
        }

        if($city != null && $city != Session::get('selectedCitySlug')) {  
            $model = City::where('slug', $city)->first();
            Session::forget('selectedCitySlug');
            Session::forget('selectedCityName');
            Session::put('selectedCitySlug', $city);
            Session::put('selectedCityName', $model->name);

            return redirect('/'.$city.'/news');
        }
        return view('news');
    }
    
    public function reset() {
        Session::forget('selectedCitySlug');
        Session::forget('selectedCityName');
        return redirect('/');
    }

    public function loadCities() {
        $response = Http::get('https://api.hh.ru/areas');
        if ($response->ok()) {
            $countriesArray = $response->json();
            $regionsArray = [];
            $citiesArray = [];

            foreach($countriesArray as $country) {   
                if ($country['name'] == 'Россия') {  
                    $regionsArray[] = $country['areas'];
                }
            }

            foreach ($regionsArray[0] as $region) { 
                if (count($region['areas'])) {
                    foreach($region['areas'] as $city)  {
                        $citiesArray[] = $city;
                    }   
                } else {
                    $citiesArray[] = $region;
                }                              
            }  

            City::truncate();

            foreach($citiesArray as $item) {
                $city = new City;
                $city->name = $item['name'];
                $city->slug = Str::slug($item['name'], '-');
                $city->save();
            }
        } 

        return redirect('/');
    }
}
