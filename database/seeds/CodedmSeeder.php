<?php

use Illuminate\Database\Seeder;
use App\Codedm;
use App\Company;
use Illuminate\Support\Facades\DB;
use App\Codeean13;

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
        for ($i = 0; $i < 4; $i++) {
            factory(Codedm::class, 50)->create([
                'codeean13_id' =>  factory(Codeean13::class)->create([
                    'company_id' => $company->id
                ])
            ]);
        }
        // factory(Codedm::class, 10)->create([
        //     'codeean13_id' =>  factory(Codeean13::class)->create([
        //             'company_id' => $company->id
        //         ])
        // ]);
        // factory(Codedm::class, 10)->create([
        //     'codeean13_id' =>  factory(Codeean13::class)->create([
        //             'company_id' => $company->id
        //         ])
        // ]);
        // factory(Codedm::class, 10)->create([
        //     'codeean13_id' =>  factory(Codeean13::class)->create([
        //             'company_id' => $company->id
        //         ])
        // ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'password' => bcrypt('admin'),
            'company_id' => $company->id
        ]);
        // factory(User::class)->create(['name'=>'admin','password' => bcrypt('admin'), 'company_id' => 1]);
    }
}
