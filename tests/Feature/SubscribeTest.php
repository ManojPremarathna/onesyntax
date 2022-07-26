<?php

namespace Tests\Feature;

use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscribeTest extends TestCase
{
    /** @test */
    public function can_subscribe_with_email_api()
    {
        $website = Website::factory()->create();

        $response = $this->postJson(
            'api/subscribe',
            [
                'email' => "manoj@test.com",
                'website_id' => $website->id
            ]
        );

        $this->assertCount(1, Subscriber::all());
    }

    /** @test */
    public function can_subscribe_with_email()
    {
        $website = Website::factory()->create();

        $response = $this->post(
            'subscribe',
            [
                'email' => "manoj@test.com",
                'website_id' => $website->id
            ]
        );

        $this->assertCount(1, Subscriber::all());
    }

    /** @test */
    /*public function a_email_is_required()
    {
        $website = Website::factory()->create();

        $response = $this->post(
            'subscribe',
            [
                'email' => "",
                'website_id' => $website->id
            ]
        );

        $response->assertSessionHasErrors('email');
    }*/
}
