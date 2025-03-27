<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class OpenWeatherHelper
{
    private string $url = 'http://api.openweathermap.org/data/2.5/find';
    private string $apiKey;

    public function __construct()
    {    
        $this->apiKey = 'c79646a737c7d1470cd7e82787e540a3';
    }


    public function getWeather(string $city): Array
    {
        $url = $this->url . '?q=' . $city . ',RU&lang=ru&type=like&units=metric&APPID=' . $this->apiKey;
        $http = new Client();
        $response = $http->request('GET', $url);
        $result = json_decode($response->getBody(), true);
        $data = [];
        if (count($result)>0) {
            $data = [
                'temp' => $result['list'][0]['main']['temp'],
                'feels_like' => $result['list'][0]['main']['feels_like'],
                'pressure' => $result['list'][0]['main']['pressure'],
                'humidity' => $result['list'][0]['main']['humidity'],
                'wind' => $result['list'][0]['wind']['speed'],
                'weather' => $result['list'][0]['weather'][0]['description'],
                'img' => 'http://openweathermap.org/img/w/' . $result['list'][0]['weather'][0]['icon'] . '.png' 
            ];
        }

        return $data;
    }
}
