<?php

use Illuminate\Database\Seeder;
use App\Company;
class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = Company::find(2);
    }
}
