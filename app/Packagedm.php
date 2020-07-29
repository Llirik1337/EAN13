<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Codedm;
use App\Statuscodedm;
// use Illuminate\Support\Facades\DB;

class Packagedm extends Model
{

    protected $fillable = [
        'package_id',
        'codedm_id'
    ];

    public function codedm()
    {
        return $this->belongsTo(Codedm::class,'codedm_id');
    }

    public static function getByPackageId($package_id)
    {
        return static::where('package_id', $package_id)->get();
    }

    public static function checkDM($codedms)
    {
        $result_codedms = [];
        $errors_codedms = [];
        if (count($codedms) > 0) {
            foreach ($codedms as $codedm_item) {
                $codedm = Codedm::getByCode($codedm_item['codedm']);
//                \Log::debug($codedm);
                if ($codedm === null) {
                    array_push($errors_codedms, ['msg' => 'Can\'t not find DM', 'DM' => $codedm_item['codedm']]);
                } else if ($codedm->status === null) {
                    array_push($errors_codedms, ['msg' => 'This DM not use', 'DM' => $codedm]);
                } else if ($codedm->status['name'] !== 'Inflicted') {
                    array_push($errors_codedms, ['msg' => 'This status DM not "Inflicted"', 'DM' => $codedm]);
                } else {
                    array_push($result_codedms, $codedm);
                }
            }
            return ['errors' => $errors_codedms, 'codedms' => $result_codedms, 'result' => count($errors_codedms) > 0 ? false : true];
        } else {
            return ['msg' => "none codedms", 'result' => false];
        }
    }

    public static function add($package_id,$codedms)
    {
//        \Log::debug('$codedms');
//        \Log::debug(json_encode($codedms));
//        \Log::debug('$package_id');
//        \Log::debug($package_id);

        $result = ['result'=> true, 'packagedms' => []];
        foreach ($codedms as $codedm_item) {
            $codedm_item->status['name'] = 'Package';
            $codedm_item->status->save();
            $packagedms = new Packagedm;
            $packagedms->package_id = $package_id;
            $packagedms->codedm_id = $codedm_item->id;
            $packagedms->save();
            array_push($result['packagedms'], $packagedms);

        }

//        \Log::debug('result');
//        \Log::debug(json_encode($result));
        return $result;
    }
}
