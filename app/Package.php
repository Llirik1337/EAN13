<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Packagedm;
use Illuminate\Support\Facades\DB;

class Package extends Model
{

    protected $fillable = ['EAN13'];

    public static function createPackage()
    {
        $package = new Package;
        $package->save();
        $package->EAN13 = 241000000000 + $package->id;
        $package->save();
        return $package;
    }

    public static function add($codedms)
    {
        if (count($codedms) > 0) {

            $result = Packagedm::checkDM($codedms);
            if ($result['result']) {
                $package = static::createPackage();
                $package_result = ['EAN13'=> $package->EAN13];
                array_push($package_result,Packagedm::add($package->id, $result['codedms']));
                return $package_result;
            } else {
                return $result;
            }
            // if ($result['result'] === false) {
            //     return $result;
            // } else {
            //     return ['EAN13' => $package->EAN13, 'result' => true];
            // }
        } else {
            return false;
        }
    }
}
