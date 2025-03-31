<?php

namespace Tests\Unit;

use App\Helpers\CountryFlagsHelper;
use App\Http\Controllers\Blog\CountryFlagController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class CountryFlagControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_index() {
        $api = $this->createMock(CountryFlagsHelper::class);
        
        $api->expects($this->once())
            ->method('getCountries')
            ->willReturn([
                ['cName' => 'Germany', 'sISOCode' => 'DE']
            ]);
        
        $controller = new CountryFlagController();
        app()->instance(CountryFlagsHelper::class, $api);

        $response = $controller->index();
        $response->assertViewHas('countries', [['cName' => 'Germany']]);
    }
    
    public function test_get() {
        $api = $this->createMock(CountryFlagsHelper::class);
        
        $api->expects($this->once())
            ->method('getCountryFlag')
            ->with('DE')
            ->willReturn([
                'url' => 'https://example.com/germany-flag.jpg',
                'mimeType' => 'image/jpeg',
            ]);
        
        $controller = new CountryFlagController();
        app()->instance(CountryFlagsHelper::class, $api);
    
        $response = $controller->get(['sISOCode' => 'DE']);
        
        $response->assertExactJson([
            'url' => 'https://example.com/germany-flag.jpg',
            'mimeType' => 'image/jpeg',
        ]);
    }
}
