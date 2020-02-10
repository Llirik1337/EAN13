<?php

use Illuminate\Database\Seeder;
use App\UserType;
class CreateUsersTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type_admin = factory(UserType::class)->create([
            'name' => 'admin'
        ]);

        $type_user = factory(UserType::class)->create([
            'name' => 'user'
        ]);
    }
}
