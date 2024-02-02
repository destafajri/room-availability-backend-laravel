<?php

namespace Tests\Feature\Search;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class SearchKostTest extends TestCase
{
    public function test_searchKostByKostNameSuccess(): void
    {
        $response = $this->get('/api/search/kost?key=testing');
        $dataResponse = $response->json('data.kost_name.0.kost_name');

        $response->assertStatus(200);
        self::assertNotEmpty($dataResponse);
        self::assertTrue(str_contains(strtolower($dataResponse), 'testing'));
    }

    public function test_searchKostByKostLocationSuccess(): void
    {
        $response = $this->get('/api/search/kost?key=jakarta');
        $dataResponse = $response->json('data.location.0');

        $response->assertStatus(200);
        self::assertNotEmpty($dataResponse);
    }

    public function test_searchKostByKostPriceSuccess(): void
    {
        $response = $this->get('/api/search/kost?key=4700000');
        $dataResponse = $response->json('data.price.0');

        $response->assertStatus(200);
        self::assertNotEmpty($dataResponse);
    }

    public function test_searchKostKeyIsNull(): void
    {
        $response = $this->get('/api/search/kost?key=');
        $dataResponse = $response->json('data');

        $response->assertStatus(200);
        self::assertEmpty($dataResponse);
    }

    public function test_searchKostKeyLessThanThreeCharacters(): void
    {
        $response = $this->get('/api/search/kost?key=de');
        $dataResponse = $response->json('data');

        $response->assertStatus(200);
        self::assertEmpty($dataResponse);
    }
}
