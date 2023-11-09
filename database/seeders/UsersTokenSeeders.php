<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

use App\Models\UsersModel as Users;
use App\Models\TokenModel as Token;

class UsersTokenSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        Users::create([
            'name' => $faker->name,
            'email' => $faker->unique()->email(),
            'password' => Hash::make('password123'),
            'created_at' => now(),
            'token' => Token::create(['token' => 'client-' . hash('md5', Str::random(15))])->id,
        ]);
    }
}
