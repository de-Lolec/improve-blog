<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(BlogCategoryTableSeeder::class);
       // BlogPost::factory()->count(100)->create();
        \App\Models\BlogPost::factory(100)->create();

        //factory(\App\Models\BlogPost::class, 100);
        // \App\Models\User::factory(10)->create();
    }
}
