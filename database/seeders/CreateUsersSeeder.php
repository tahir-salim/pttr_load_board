<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
               'name'=>'Super Admin',
               'email'=>'admin@yopmail.com',
               'type'=>0,
               'password'=> Hash::make('12345678'),
               'email_verified_at'=>Carbon::now()
            ],
            [
               'name'=>'Trucker User',
               'email'=>'trucker@yopmail.com',
               'type'=> 1,
               'password'=> Hash::make('12345678'),
               'email_verified_at'=>Carbon::now()
            ],
            [
               'name'=>'Shipper User',
               'email'=>'shipper@yopmail.com',
               'type'=>2,
               'password'=> Hash::make('12345678'),
               'email_verified_at'=>Carbon::now()
            ],
            [
               'name'=>'Broker User',
               'email'=>'broker@yopmail.com',
               'type'=>3,
               'password'=> Hash::make('12345678'),
               'email_verified_at'=>Carbon::now()
            ],
        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }

    }
}
