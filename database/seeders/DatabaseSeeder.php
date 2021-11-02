<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Author;
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
         \App\Models\Rubric::factory(10)->create();
        Author::factory(10)->create();
        Article::factory(500)->create();
    }
}
