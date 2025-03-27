<?php

namespace Tests\Unit;

use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ApiServiceTest extends TestCase
{
    /** @test */
    public function test_api_service()
    {
        
        $http = new Client();
        $response = $http->request('GET', 'https://api.openweathermap.org/data/2.5/weather');
        
        // Assert that the API response is correct
        $this->assertTrue($response['status']);

    }
}