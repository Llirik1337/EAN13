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
        // \Log::debug('login');

        // \Log::debug(config('app.admin_login'));
        // \Log::debug('password');
        // \Log::debug(config('app.admin_login'));
        // \Log::debug('company');
        // \Log::debug(config('app.admin_compnay'));
        $company = Company::firstOrCreate(['name' => config('app.admin_company')]);
        $user_type_admin = UserType::where('name', 'admin')->get()->first();
        // \Log::debug($company);
        $admin = User::updateOrCreate([
            'name' => config('app.admin_login'),

        ], [
            'password' => bcrypt(config('app.admin_password')),
            'company_id' => $company->id,
            'user_types_id' => $user_type_admin->id
        ]);
        // $admin = factory(User::class)->create(['name' => env('app.admin_login'), 'password' =>  env('app.admin_password'), 'company_id' => $company->id]);
        // \Log::debug('admin');
        // \Log::debug($admin);
    }
}
