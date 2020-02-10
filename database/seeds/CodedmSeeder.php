<?php

use Illuminate\Database\Seeder;
use App\Codedm;
use App\Company;
use Illuminate\Support\Facades\DB;
use App\Codeean13;
use App\UserType;
use App\TypeRight;
use App\User;
use App\Right;
class CodedmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = factory(Company::class)->create();
        for ($i = 0; $i < 20; $i++) {
            factory(Codedm::class, 20)->create([
                'codeean13_id' =>  factory(Codeean13::class)->create([
                    'company_id' => $company->id
                ])
            ]);
        }

        // DB::table('user_types')->insert([
        //     'name' => 'admin'
        // ]);

        // DB::table('user_types')->insert([
        //     'name' => 'user'
        // ]);

        // DB::table('type_rights')->insert([

        // ]);

        // $type_admin = factory(UserType::class)->create([
        //     'name' => 'admin'
        // ]);

        // $type_user = factory(UserType::class)->create([
        //     'name' => 'user'
        // ]);


        // $right_adminPanel = factory(Right::class)->create([
        //     'name' => 'adminPanel'
        // ]);
        // $right_marking = factory(Right::class)->create([
        //     'name' => 'marking'
        // ]);
        // $right_statistics = factory(Right::class)->create([
        //     'name' => 'statistics'
        // ]);

        // factory(TypeRight::class)->create([
        //     'right_id'=> $right_adminPanel->id,
        //     'user_types_id'=>$type_admin->id,
        // ]);
        // factory(TypeRight::class)->create([
        //     'right_id'=> $right_marking->id,
        //     'user_types_id'=>$type_admin->id,
        // ]);
        // factory(TypeRight::class)->create([
        //     'right_id'=>$right_statistics->id,
        //     'user_types_id'=>$type_admin->id,
        // ]);

        // factory(TypeRight::class)->create([
        //     'right_id'=> $right_marking->id,
        //     'user_types_id'=>$type_user->id,
        // ]);
        // factory(TypeRight::class)->create([
        //     'right_id'=>$right_statistics->id,
        //     'user_types_id'=>$type_user->id,
        // ]);

        // factory(User::class)->create([
        //     'name' => 'admin',
        //     'password' => bcrypt('admin'),
        //     'company_id' => $company->id,
        //     'user_types_id' => $type_admin->id
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'admin',
        //     'password' => bcrypt('admin'),
        //     'company_id' => $company->id
        // ]);
    }
}
