<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$adminUser = [
    		'name' => 'admin',
    		'email' => 'admin@gmail.com',
    		'password' => bcrypt('admin'),
    	];

    	if(!User::where('email', $adminUser['email'])->exists())
    	{
    		User::create($adminUser);
    	}

         // $this->call(UsersTableSeeder::class);
    }
}
