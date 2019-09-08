<?php

namespace App\Actions;

use App\Utilities\Curl;
use Illuminate\Http\Request;
use App\Actions\StoreCountry;

class RetrieveFromApi
{
    /**
     * Run fetchs from API and store in the DB.
     */
    public static function run(Request $request)
    {
        $countries = collect([]);
        $api = new static;
        if ($request->filled('country_code')){
            $countries = $countries->concat(
                $api->byCountryCode($request->input('country_code'))
            );
        }

        if ($request->filled('country_name')){
            $countries = $countries->concat(
                $api->bySearch('name', $request->input('country_name'))
            );
        }

        if ($request->filled('capital')){
            $countries = $countries->concat(
                $api->bySearch('capital', $request->input('capital'))
            );
        }

        if ($request->filled('currency')){
            $countries = $countries->concat(
                $api->bySearch('currency', $request->input('currency'))
            );
        }

        if ($request->filled('language')){
            $countries = $countries->concat(
                $api->bySearch('lang', $request->input('language'))
            );
        }

        return $countries;
    }

    /**
     * Search for country codes.
     */
    private function byCountryCode($codes)
    {
        $codes = preg_split("/[\s,;]+/", $codes);
        $data = $this->apiCall('alpha?codes=' . implode(';', $codes));

        return $this->store($data);
    }

    /**
     * Search and store for given type with search value.
     */
    private function bySearch($type, $value)
    {
        $data = $this->apiCall($type . '/' . $value);
        return $this->store($data);
    }
    
    /**
     * Store Data as Countries.
     */
    private function store($data)
    {
        if(!static::dataIsGood($data)){ return []; }

        // Api returns an array of countries.
        return collect($data)->map(function($d){
            return StoreCountry::run($d);
        });
    }

    /**
     * Check that the data supplied by the API is correct.
     * Simple checking that data is found.
     */
    private static function dataIsGood($data)
    {
        return isset($data) 
            && (!isset($data['status']) 
                || ($data['status'] !== 400 && $data['status'] !== 404 && $data['status'] !== 500));
    }

    /**
     * Make request to APIs
     */
    private function apiCall($url)
    {
        return Curl::init("https://restcountries.eu/rest/v2/$url")
        ->setData([
            'fields' => 'name;callingCodes;region;capital;timezones;currencies;flag;alpha2Code;alpha3Code;languages'
        ])
        ->getJson();
    }
}