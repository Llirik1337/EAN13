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

                $number = random_int(100, 1000);


                $cargo = factory(Cargo::class)->create(['number' => $number]);
                $codeean13 = factory(Codeean13::class)->create([
                    'company_id' => $company->id
                ]);
                $codedms = factory(Codedm::class, 10)->create([
                    'codeean13_id' => $codeean13->id
                ]);
                $cargo->codeean()->save($codeean13);
                foreach ($codedms as $code) {
                    $code->cargo_id = $cargo->id;
                    $code->save();
                }
                $codeean13 = factory(Codeean13::class)->create([
                    'company_id' => $company->id
                ]);
                $codedms = factory(Codedm::class, 10)->create([
                    'codeean13_id' => $codeean13->id
                ]);
                $cargo->codeean()->save($codeean13);
                foreach ($codedms as $code) {
                    $code->cargo_id = $cargo->id;
                    $code->save();
                }



                $codedms = factory(Codedm::class, 25)->create([
                    'codeean13_id' => $codeean13->id
                ]);
            }
    }
}
