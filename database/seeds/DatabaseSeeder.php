<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        // This will register corresponding seeders into main database seeder.
        $this->call(PostTableSeeder::class);
        $this->call(TagTableSeeder::class);
    }
}
