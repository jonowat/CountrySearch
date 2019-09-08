<?php

namespace App\Http\Controllers;

use App\Country;
use App\Currency;
use App\Language;
use App\Dialingcode;
use App\Utilities\Curl;
use Illuminate\Http\Request;
use App\Actions\RetrieveFromDb;
use App\Actions\RetrieveFromApi;
use Illuminate\Database\Eloquent\Builder;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    public function search(Request $request)
    {
        // Validate search values.
        // at least one field required
        $request->validate([
            'country_name' => 'required_without_all:country_code,capital,currency,language',
            'country_code' => 'required_without_all:country_name,capital,currency,language',
            'capital' => 'required_without_all:country_name,country_code,currency,language',
            'currency' => 'required_without_all:country_name,country_code,capital,language',
            'language' => 'required_without_all:country_name,country_code,capital,currency'
        ]);
        
        // If validation fails, a redirect response will be generated to send the user back to their previous location.
        $countries = RetrieveFromDb::run($request);
        
        // There could be more data, but display what we currently have.
        if($countries->count() > 0)
        {
            return view('welcome', ['countries' => $countries]);
        }

        $countries = RetrieveFromApi::run($request);
        return view('welcome', ['countries' => $countries]);
    }
}
