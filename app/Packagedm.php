<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Codedm;
use App\Statuscodedm;
use Illuminate\Support\Facades\DB;

class Packagedm extends Model
{

    protected $fillable = [
        'package_id',
        'codedm_id'
    ];

    public static function add($codeeanPackage_id, $codedms)
    {
        \Log::debug('$codedms');
        \Log::debug($codedms);
        $results = ['result' => true];
        if (count($codedms) > 0) {
            DB::beginTransaction();
            foreach ($codedms as $codedm_item) {
                $codedm = Codedm::getByCode($codedm_item['codedm']);
                if ($codedm === null) {
                    DB::rollBack();
                    return ['msg' => 'Can\'t not find DM', 'DM' => $codedm_item['codedm'], 'result' => false];
                }
                if ($codedm->status === null) {
                    DB::rollBack();
                    return ['msg' => 'This DM not use', 'DM' => $codedm, 'result' => false];
                }
                if ($codedm->status === 'Inflicted') {
                    $codedm->status->name = "Package";
                    $codedm->save();
                } else {
                    DB::rollBack();
                    return ['DM' => $codedm, 'result' => false];
                }
                $packagedm = new Packagedm;
                $packagedm->package_id = $codeeanPackage_id;
                $packagedm->codedm_id = $codedm->id;
                $packagedm->save();
                array_push($results, $packagedm);
            }
            DB::commit();
            return $results;
        } else {
            return false;
        }
        // });
    }
}
