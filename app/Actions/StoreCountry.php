<?php

namespace App\Actions;

use App\Country;
use App\Currency;
use App\Language;

class StoreCountry
{
    public static function run($data)
    {
        $country = Country::create([
            'name' => $data['name'],
            'region' => $data['region'],
            'code2' => $data['alpha2Code'],
            'code3' => $data['alpha3Code'],
            'capital' => $data['capital'],
            'flag' => $data['flag']
        ]);

        $currencies = collect($data['currencies'])
            ->filter(function($currencyData){
                return isset($currencyData['code'])
                    && $currencyData['code'] !== null
                    && $currencyData['code'] !== "(none)";
            })
            ->map(function($currencyData) {
                return Currency::firstOrCreate($currencyData);
            });
        $country->currencies()->saveMany($currencies);

        $languages = collect($data['languages'])
            ->map(function($languageData) {
                return Language::firstOrCreate($languageData);
            });
        $country->languages()->saveMany($languages);

        $country->dialingcodes()->createMany(collect($data['callingCodes'])
            ->map(function($callingCode) {
                return ['code'=>$callingCode];
            }));

        $country->timezones()->createMany(collect($data['timezones'])
            ->map(function($timezone) {
                return ['timezone'=>$timezone];
            }));

        return $country;
    }
}