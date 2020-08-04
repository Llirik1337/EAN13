<?php

use Illuminate\Database\Seeder;
class DevSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CodedmSeeder::class,
            CreateUsersTypes::class,
            CreateAdmin::class,
            RussianUserSeed::class
        ]);
    }
}
