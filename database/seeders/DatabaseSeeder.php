<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Listing;
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
        
        $user = User::factory()->create([
            'name'=> 'sirYoung',
            'email'=> 'siryoung@gmail.com',
            'password'=> '1234567'
        ]);
        Listing::factory(5)->create([
            'user_id' => $user->id
        ]);
        
    }
}
