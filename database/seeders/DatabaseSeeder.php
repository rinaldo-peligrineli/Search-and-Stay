<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
          'name' => 'Search and Stay Assessment Test',
          'email' => 'assessment.test@searchandstay.com',
          'password' => '12345678',

        ]);
    }
}
