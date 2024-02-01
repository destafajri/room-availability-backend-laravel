<?php

namespace Tests\Feature\RoomAvailability;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoomAvailabilityTest extends TestCase
{
    public function test_RoomAvailabilitySuccess(): void
    {
        // setup
        $responseLogin = $this->post('/api/login', [
            'phone_number' => '081197878841',
            'password' => '123456'
        ]);
        $responseKostList = $this->get('/api/kost');
        $id = (int) $responseKostList->json('data.0.id');

        // act
        $response = $this->post("/api/kost/$id/ask-room", [], [
            'Authorization' => 'Bearer ' . $responseLogin['data']['token']
        ]);

        // assert
        $response->assertStatus(200)
            ->assertJson([
                "data" => [
                    'room_message' => "Haii! Rooms are open! 2 spots left. Don't miss out! Book now!"
                ]
            ]);
    }

    public function test_RoomAvailabilitySoldOutSuccess(): void
    {
        // setup
        $responseLogin = $this->post('/api/login', [
            'phone_number' => '081197878841',
            'password' => '123456'
        ]);
        $responseKostList = $this->get('/api/kost');
        $id = (int) $responseKostList->json('data.1.id');

        // act
        $response = $this->post("/api/kost/$id/ask-room", [], [
            'Authorization' => 'Bearer ' . $responseLogin['data']['token']
        ]);

        // assert
        $response->assertStatus(200)
            ->assertJson([
                "data" => [
                    'room_message' => "We are so sorry that our room is already fully booked."
                ]
            ]);
    }

    public function test_TenantDoentHasCredit(): void
    {
        // setup
        $responseLogin = $this->post('/api/login', [
            'phone_number' => '081197878843',
            'password' => '123456'
        ]);
        $responseKostList = $this->get('/api/kost');
        $id = (int) $responseKostList->json('data.1.id');

        // act
        $response = $this->post("/api/kost/$id/ask-room", [], [
            'Authorization' => 'Bearer ' . $responseLogin['data']['token']
        ]);

        // assert
        $response->assertStatus(422)
            ->assertJson([
                "error" => [
                    'Credit is not enough, your credit is 1'
                ]
            ]);
    }
}
