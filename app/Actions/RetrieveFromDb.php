<?php

namespace App\Actions;

use App\Country;
use Illuminate\Http\Request;

class RetrieveFromDb
{
    public static function run(Request $request)
    {
        return Country::whereRaw('1=0')
        ->when($request->input('country_name'), function ($query, $country_name) {
            return $query->orWhere('name', $country_name)
                ->orWhere('name','like', '%' . $country_name . '%');//allow for partial names
        })
        ->when($request->input('country_code'), function ($query, $country_code) {
            $codes = preg_split("/[\s,;]+/", $country_code);
            return $query->orWhereIn('code2', $codes)
                ->orWhereIn('code3', $codes);
        })
        ->when($request->input('capital'), function ($query, $capital) {
            return $query->orWhere('capital', $capital);
        })
        ->when($request->input('currency'), function ($query, $currency) {
            return $query->orWhereHas('currencies', function (Builder $query) use ($currency) {
                return $query->where('code', $currency);
            });
        })
        ->when($request->input('language'), function ($query, $language) {
            return $query->orWhereHas('languages', function (Builder $query) use ($language) {
                $query->where('iso639_1', $language)
                ->orWhere('iso639_2', $language)
                ->orWhere('name', $language)
                ->orWhere('nativeName', $language);
            });
        })
        ->get();
    }
}