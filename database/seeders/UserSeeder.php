<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
    	$user1 = User::create([
    		'username' => 'administrator',
    		'email' => 'administrator@example.com',
    		'password' => Hash::make('password'),
    	]);
      $user1->assignRole('admin');
    }
}
