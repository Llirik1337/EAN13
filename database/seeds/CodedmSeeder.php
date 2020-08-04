<?php

use Illuminate\Database\Seeder;
use App\Codedm;
use App\Company;
use App\Codeean13;
use App\Cargo;
use Illuminate\Support\Facades\Log;
use App\CargoCodedm;
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
            Log::debug(__CLASS__);
            Log::debug(__FUNCTION__);
            for ($i = 0; $i < 20; $i++) {
                factory(Codedm::class, 50)->create([
                    'codeean13_id' => factory(Codeean13::class)->create([
                        'company_id' => $company->id
                    ])
                ]);

            }
            $company = factory(Company::class)->create(['external'=>false]);
            for ($i = 0; $i < 20; $i++) {
                $codedms = factory(Codedm::class, 50)->create([
                    'codeean13_id' => factory(Codeean13::class)->create([
                        'company_id' => $company->id
                    ])
                ]);

                $number = random_int(100,1000);
                $cargo = factory(Cargo::class)->create(['company_id'=>$company->id,'number'=>$number]);
                foreach ($codedms as $code) {

                    $code->cargo_id = $cargo->id;
                    $code->save();
                }
            }
    }
}
