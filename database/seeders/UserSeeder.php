<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $system = new User();
        $system->name = "admin";
        $system->type = 1;
        $system->email = "admin@gmail.com";
        $system->password = Hash::make('1qazxsw2');
        $system->save();
    }
}
