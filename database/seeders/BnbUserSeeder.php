<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\BnbUser;

class BnbUserSeeder extends Seeder
{
    public function run()
    {
        BnbUser::create([
            'username' => 'kelvinanderson',
            'useremail' => 'kelvinandersonpaulo@gmail.com',
            'profileimage' => null,
            'password' => Hash::make('password'),
            'telephone' => null,
            'status' => 'active',
            'role' => 'bnbadmin',
            'createdby' => 'saysdefaultadmin',
        ]);
    }
}
