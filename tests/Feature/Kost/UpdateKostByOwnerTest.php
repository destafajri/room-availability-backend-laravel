<?php

namespace Tests\Feature\Kost;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateKostByOwnerTest extends TestCase
{
    public function test_UpdateKostSuccess(): void
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
        $response = $this->put('/api/owner/kost/' . $id, [
            'kost_name' => 'kost edit nama',
            'facilities' => [5, 1, 3, 2],
            'price' => 8500000,
            'gender_id' => 2,
            'area_id' => 1,
            'address' => 'kost feature edit testing gang 1000',
            'description' => 'heheh edit description',
            'room_total' => 10,
            'room_available' => 9
        ], [
            'Authorization' => 'Bearer ' . $responseLogin['data']['token']
        ]);

        // assert
        $response->assertStatus(200);

        $responseDetail = $this->get('/api/kost/' . $id);
        $responseData = $responseDetail->json('data.kost_name');
        self::assertEquals($responseData, 'kost edit nama');
    }

    // public function test_UpdateKostUnauthorized(): void
    // {
    //     // setup
    //     $responseLogin = $this->post('/api/login', [
    //         'phone_number' => '08119787884',
    //         'password' => '123456'
    //     ]);

    //     $this->post('/api/owner/kost', [
    //         'kost_name' => 'kost feature testing',
    //         'facilities' => [1, 3, 2],
    //         'price' => 850000,
    //         'gender_id' => 3,
    //         'area_id' => 4,
    //         'address' => 'kost feature testing gang 1000',
    //         'description' => 'heheh description',
    //         'room_total' => 10,
    //         'room_available' => 5
    //     ], [
    //         'Authorization' => 'Bearer ' . $responseLogin['data']['token']
    //     ]);
    //     $responseKostOwner = $this->get('/api/owner/kost?per_page=2', [
    //         'Authorization' => 'Bearer ' . $responseLogin['data']['token']
    //     ]);

    //     $id = (int) $responseKostOwner->json('data.0.id');

    //     $this->post('/api/logout', [], [
    //         'Authorization' => 'Bearer ' . $responseLogin['data']['token']
    //     ]);

    //     // act
    //     $responseLoginOwner2 = $this->post('/api/login', [
    //         'phone_number' => '08119787881',
    //         'password' => '123456'
    //     ]);
    //     $response = $this->put('/api/owner/kost/' . $id, [
    //         'kost_name' => 'kost edit nama',
    //         'facilities' => [5, 1, 3, 2],
    //         'price' => 8500000,
    //         'gender_id' => 2,
    //         'area_id' => 1,
    //         'address' => 'kost feature edit testing gang 1000',
    //         'description' => 'heheh edit description',
    //         'room_total' => 10,
    //         'room_available' => 9
    //     ], [
    //         'Authorization' => 'Bearer ' . $responseLoginOwner2['data']['token']
    //     ]);

    //     // assert
    //     $response->assertStatus(401);
    // }
}
