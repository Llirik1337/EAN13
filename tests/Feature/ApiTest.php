<?php

namespace Tests\Feature;

use App\Company;
use App\Codeean13;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Тест на замену Ean13
     * @return void
     */
    public function testUpdateEan13()
    {
        $company = factory(Company::class)->create();

        $codeean13 = factory(Codeean13::class, 20)->create([
            'company_id' => $company->id
        ]);

        $old = [];
        $new = [];
        foreach ($codeean13 as $code) {
            array_push($old, $code->code);
        }
        foreach ($codeean13 as $code) {
            array_push($new, strrev($code->code));
        }
        // echo json_encode($old);
        // echo json_encode($new);

        $json = ['data' => ['old' => $old, 'new' => $new]];
        // echo json_encode($json);
        $res = $this->postJson('codeean13/update', $json);
        // echo json_encode($res);
        $res->assertStatus(200);
    }

    /**
     * Тест на отправку замену Ean13 без данных
     * @return void
     */
    public function testNullUpdateEan13()
    {
        $res = $this->postJson('codeean13/update');
        $res->assertStatus(400);
    }
    /**
     * Тест на ошибку при замене Ean13
     * @return void
     */
    public function testErrorUpdateEan13()
    {
        $company = factory(Company::class)->create();

        $codeean13 = factory(Codeean13::class, 20)->create([
            'company_id' => $company->id
        ]);

        $old = [];
        $new = [];
        foreach ($codeean13 as $code) {
            array_push($old, $code->code);
        }

        $json = ['data' => ['old' => $old, 'new' => $new]];
        // echo json_encode($json);
        $res = $this->postJson('codeean13/update', $json);
        // echo json_encode($res);
        $res->assertStatus(400);
    }
}
