<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Website;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         Website::factory(20)->create();
         Post::factory(20)->create();
         // Subscriber::factory(20)->create();
    }
}
