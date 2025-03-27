<?php

namespace App\Http\Controllers\Blog;

use App\Helpers\CountryFlagsHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CountryFlagController extends Controller
{
    public function index()
    {
        $api = new CountryFlagsHelper();
        $countries = $api->getCountries();

        return Inertia::render('Blog/CountryFlagsForm', [
            'countries' => $countries
        ]);
    }

    public function get(Request $request)
    {
        $request->validate([
            'country' => 'required'
        ]);

        $api = new CountryFlagsHelper();
        $flag= $api->getCountryFlag($request->country['sISOCode']);

        return $flag;
    }
}
