<?php

use Illuminate\Database\Seeder;
use App\User;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $intial_user=User::create(['name'=>'testuser','email'=>'testuser@gmail.com','password'=>bcrypt('test')]);
    } 
}
