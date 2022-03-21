<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();
        \App\Models\Comment::factory(3)->create(['book_id'=>1]);
        \App\Models\Comment::factory(3)->create(['book_id'=>2]);
        \App\Models\Comment::factory(3)->create(['book_id'=>3]);
        \App\Models\Comment::factory(3)->create(['book_id'=>4]);
        \App\Models\Comment::factory(3)->create(['book_id'=>5]);
        \App\Models\Comment::factory(3)->create(['book_id'=>6]);
        \App\Models\Comment::factory(3)->create(['book_id'=>7]);
        \App\Models\Comment::factory(3)->create(['book_id'=>8]);
        \App\Models\Comment::factory(4)->create(['book_id'=>9]);
    }
}
