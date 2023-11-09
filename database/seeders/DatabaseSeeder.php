<?php

use Database\Seeders\UsersTokenSeeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UsersTokenSeeders::class,
        ]);
    }
}
