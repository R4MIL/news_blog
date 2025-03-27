<?php

namespace App\Http\Controllers\Blog;

use App\Helpers\OpenWeatherHelper;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;


class WeatherController extends Controller
{
   public function index()
   { 
       $cities = [
           'Казань',
           'Санкт-Петербург',
           'Москва',
           'Уфа',
           'Сочи'
       ];

       return Inertia::render('Blog/WeatherForm', [
           'cities' => $cities
       ]);
   }

   public function get(Request $request)
   {    
       $request->validate([
           'city' => 'required'
       ]);

       $api = new OpenWeatherHelper();
       return $api->getWeather($request->city);
   }
}
