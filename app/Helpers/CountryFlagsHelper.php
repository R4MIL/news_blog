<?php

namespace App\Helpers;

use RicorocksDigitalAgency\Soap\Facades\Soap;

class CountryFlagsHelper
{
    private string $url = 'http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso' . '?WSDL';

    public function __construct()
    {
    }

    public function getCountries(): array
    {
        $response = Soap::to($this->url)->call('ListOfCountryNamesByName');
        return $response ? collect($response->ListOfCountryNamesByNameResult->tCountryCodeAndName)->toArray() : [];
    }

    public function getCountryFlag(string $code): string
    {
        $response = Soap::to($this->url)->call('CountryFlag', ['sCountryISOCode' => $code]);
        return $response ? $response->CountryFlagResult : '';
    }
}