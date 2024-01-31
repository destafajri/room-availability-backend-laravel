<?php

namespace Tests\Feature\Kost;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class GetDetailKostDetailTest extends TestCase
{
    public function test_GetDetailKostSuccess(): void
    {
        // setup
        $responseLogin = $this->post('/api/login', [
            'phone_number' => '08119787884',
            'password' => '123456'
        ]);

        $this->post('/api/owner/kost', [
            'kost_name' => 'kost feature testing',
            'facilities' => [1, 3, 2],
            'price' => 850000,
            'gender_id' => 3,
            'area_id' => 4,
            'address' => 'kost feature testing gang 1000',
            'description' => 'heheh description',
            'room_total' => 10,
            'room_available' => 5
        ], [
            'Authorization' => 'Bearer ' . $responseLogin['data']['token']
        ]);
        $responseKostOwner = $this->get('/api/owner/kost?per_page=2', [
            'Authorization' => 'Bearer ' . $responseLogin['data']['token']
        ]);

        $id = (int) $responseKostOwner->json('data.0.id');

        // act
        $response = $this->get('/api/kost/' . $id);

        // assert
        $response->assertStatus(200);
        $responseData = $response->json('data');
        $this->assertNotNull($responseData);
    }
}
