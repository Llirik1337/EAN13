<?php

use Illuminate\Database\Seeder;
use App\Company;
use App\User;
use App\UserType;

class CreateAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_type_admin = UserType::where('name', 'admin')->get()->first();
        $admin = User::updateOrCreate([
            'name' => config('app.admin_login'),

        ], [
            'password' => bcrypt(config('app.admin_password')),
            'company_id' => Company::find(1)->id,
            'user_types_id' => $user_type_admin->id
        ]);
    }
}
