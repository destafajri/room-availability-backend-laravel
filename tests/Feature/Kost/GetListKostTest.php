<?php

namespace Tests\Feature\Kost;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetListKostTest extends TestCase
{
    public function test_GetListKostByOwnerSuccess(): void
    {
        // setup
        $responseLogin = $this->post('/api/login', [
            'phone_number' => '08119787884',
            'password' => '123456'
        ]);

        $this->post('/api/kost/owner', [
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

        // act
        $response = $this->get('/api/kost/owner?per_page=2', [
            'Authorization' => 'Bearer ' . $responseLogin['data']['token']
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' =>
                    array(
                        0 =>
                            array(
                                'kost_name' => 'kost feature testing',
                                'owner' => 'owner tester feature',
                                'address' => 'kost feature testing gang 1000',
                                'price' => 850000,
                                'kost_gender' => 'CAMPUR',
                                'area' => 'Semarang',
                                'description' => 'heheh description',
                                'room_total' => 10,
                                'room_available' => 5
                            )
                    )
            ]);
    }

    public function test_GetListKostByOwnerUserUnauthorized(): void
    {
        // setup
        $responseLogin = $this->post('/api/login', [
            'phone_number' => '081197878841',
            'password' => '123456'
        ]);

        // act
        $response = $this->get('/api/kost/owner?per_page=2', [
            'Authorization' => 'Bearer ' . $responseLogin['data']['token']
        ]);

        $response->assertStatus(403);
    }
}
