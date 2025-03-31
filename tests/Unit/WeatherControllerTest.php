<?php

namespace Tests\Unit;

use App\Helpers\OpenWeatherHelper;
use App\Http\Controllers\Blog\WeatherController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class WeatherControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_index() {
        $api = $this->createMock(OpenWeatherHelper::class);

        $api->expects($this->once())
            ->method('getWeather')
            ->with('Москва')
            ->willReturn([
                'temperature' => 15,
                'pressure' => 700,
            ]);
        
        $controller = new WeatherController();
        app()->instance(OpenWeatherHelper::class, $api);
    
        $response = $controller->get(['city' => 'Москва']);
        
        $response->assertExactJson([
            'temperature' => 15,
            'pressure' => 700,
        ]);
    }
}
