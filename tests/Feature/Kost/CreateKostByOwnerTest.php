<?php

namespace Tests\Feature\Kost;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateKostByOwnerTest extends TestCase
{
    public function test_OwnerSuccessCreateKost(): void
    {
        // setup
        $responseLogin = $this->post('/api/login', [
            'phone_number' => '08119787884',
            'password' => '123456'
        ]);

        // act
        $response = $this->post('/api/kost/owner', [
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

        // assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'success create new kost'
            ]);
    }

    public function test_OwnerFailedPayloadForCreateKost(): void
    {
        // setup
        $responseLogin = $this->post('/api/login', [
            'phone_number' => '08119787884',
            'password' => '123456'
        ]);

        // act
        $response = $this->post('/api/kost/owner', [
            'kost_name' => 'kost feature testing',
            'facilities' => [1, 3, 2],
            'gender_id' => 3,
            'area_id' => 4,
            'address' => 'kost feature testing gang 1000',
            'description' => 'heheh description',
            'room_total' => 10,
            'room_available' => 5
        ], [
            'Authorization' => 'Bearer ' . $responseLogin['data']['token']
        ]);

        // assert
        $response->assertStatus(422)
            ->assertJson([
                'error' => [
                    'price' => [
                        'The price field is required.'
                    ]
                ]
            ]);
    }

    public function test_OwnerFailedCreateHostelRoomAVailableGreaterThanRoomTotal(): void
    {
        // setup
        $responseLogin = $this->post('/api/login', [
            'phone_number' => '08119787884',
            'password' => '123456'
        ]);

        // act
        $response = $this->post('/api/kost/owner', [
            'kost_name' => 'kost feature testing',
            'facilities' => [1, 3, 2],
            'price' => 850000,
            'gender_id' => 3,
            'area_id' => 4,
            'address' => 'kost feature testing gang 1000',
            'description' => 'heheh description',
            'room_total' => 10,
            'room_available' => 15
        ], [
            'Authorization' => 'Bearer ' . $responseLogin['data']['token']
        ]);

        // assert
        $response->assertStatus(422)
            ->assertJson([
                'error' => [
                    'room_available' => [
                        'The room available field must be between 0 and 10.'
                    ]
                ]
            ]);
    }
}
