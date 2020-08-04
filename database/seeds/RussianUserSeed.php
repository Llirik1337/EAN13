<?php

use Illuminate\Database\Seeder;
use App\Company;
use App\UserType;
use App\User;
class RussianUserSeed extends Seeder
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
            'name' => 'russian',
        ], [
            'password' => bcrypt(config('app.admin_password')),
            'company_id' => Company::find(2)->id,
            'user_types_id' => $user_type_admin->id,
        ]);
//        $admin = factory(User::class)->state(russian)->create([
//            'name'=>'russian',
//            'password' => bcrypt(config('app.admin_password')),
//            'user_types_id' => $user_type_admin->id,
//            'company_id' => Company::find(2)->id,
//        ]);
    }
}
