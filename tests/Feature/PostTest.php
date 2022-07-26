<?php

namespace Tests\Feature;

use App\Jobs\SendEmailJob;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function post_create_test()
    {
        // $this->withoutExceptionHandling();
        $website = Website::factory()->create();

        $response = $this->postJson(
            'api/posts',
            [
                'title'       => 'Test Title',
                'description' => 'Test Description',
                'website_id'  => $website->id,
            ]
        );

        $response->assertOk();
        $this->assertCount(1, Post::all());
    }

    /** @test */
    /*public function a_title_is_required()
    {
        $website = Website::factory()->create();

        $response = $this->postJson(
            'api/posts',
            [
                'title'       => '',
                'description' => 'Test Description',
                'website_id'  => $website->id,
            ]
        );

        $response->assertSessionHasErrors('title');
    }*/

    /** @test */
    public function a_post_can_update()
    {
        $website = Website::factory()->create();

        $this->postJson(
            'api/posts',
            [
                'title'       => 'Test Title',
                'description' => 'Test Description',
                'website_id'  => $website->id,
            ]
        );

        $post = Post::first();

        $this->putJson(
            'api/posts/' . $post->id,
            [
                'title'       => 'Updated Test Title',
                'description' => 'Updated Test Description',
                'website_id'  => $website->id,
            ]
        );

        $this->assertEquals('Updated Test Title', Post::first()->title);
        $this->assertEquals('Updated Test Description', Post::first()->description);
    }

    /** @test */
    public function a_post_can_delete()
    {
        $website = Website::factory()->create();

        $this->postJson(
            'api/posts',
            [
                'title'       => 'Test Title',
                'description' => 'Test Description',
                'website_id'  => $website->id,
            ]
        );

        $post = Post::first();
        // check record added
        $this->assertCount(1, Post::all());

        $this->deleteJson('api/posts/' . $post->id,);
        $this->assertCount(0, Post::all());
    }

    /** @test */
    /*public function send_email_after_adding_post()
    {
        $website = Website::factory()->create();
        // add subscriber
        Subscriber::factory()->create();

        $response = $this->postJson(
            'api/posts',
            [
                'title'       => 'Test Title',
                'description' => 'Test Description',
                'website_id'  => $website->id,
            ]
        );

        $this->expectsJobs(SendEmailJob::class);
    }*/
}
