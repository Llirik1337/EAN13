<?php

namespace Tests\Feature;

use App\Codedm;
use App\Company;
use App\Codeean13;
use App\User;
use App\UserType;
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
//    public function testUpdateEan13()
//    {
//        $userType = factory(UserType::class)->create();
////        var_dump(json_encode($userType));
//        $user = factory(User::class)->create([
//            'user_types_id'=>$userType->id
//        ]);
//        $codeean13 = factory(Codeean13::class, 20)->create([
//            'company_id' => $user->company_id
//        ]);
//
//        $old = [];
//        $new = [];
//        foreach ($codeean13 as $code) {
//            array_push($old, $code->code);
//        }
//        foreach ($codeean13 as $code) {
//            array_push($new, strrev($code->code));
//        }
//
//        $json = ['data' => ['old' => $old, 'new' => $new]];
//        $res = $this->actingAs($user)->postJson('codeean13/update', $json);
//        $res->assertStatus(200);
//    }

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

    public function testGetAllDmcode() {

        $userType = factory(UserType::class)->create();
//        var_dump(json_encode($userType));
        $user = factory(User::class)->create([
            'user_types_id'=>$userType->id
        ]);
        $this->actingAs($user);
        $codeean = factory(Codeean13::class)->create();
        $codedms = factory(Codedm::class, 20)->create([
            'codeean13_id' =>  factory(Codeean13::class)->create([
                'company_id' => $user->company_id
            ])
        ]);
        $reqData = ['codeean'=>$codeean->code];
        $res = $this->post('codeean13/getAllDM', $reqData);
        $res->assertStatus(200)->assertJson(['data'=>true]);
    }
}
