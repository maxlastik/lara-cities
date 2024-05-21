<?php

namespace App\Http\Controllers;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CityController extends Controller
{
    public function store(Request $request) {
        $city = new City;
        $city->name = $request->name;
        $city->slug = Str::slug($request->name, '-');
        $city->save();

        return response()->json([
            'message' => 'Ok'
        ]);
    }

    public function destroy($city) {
        $model = City::where('slug', $city)->first();
        $model->delete();

        return response()->json([
            'message' => 'Ok'
        ]);
    }
}
