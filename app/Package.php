<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Packagedm;
use Illuminate\Support\Facades\DB;

class Package extends Model
{

    protected $fillable = ['EAN13'];

    public static function add($codedms)
    {
        if (count($codedms) > 0) {
            DB::beginTransaction();
            $package = new Package;
            $package->save();
            $package->EAN13 = 2410000000000 + $package->id;
            $package->save();
            \Log::debug('$package');
            \Log::debug(json_encode($package));
            $result = Packagedm::add($package->id, $codedms);
            \Log::debug('result');
            \Log::debug(json_encode($result));
            if ($result['result'] === false) {
                DB::rollBack();
                return $result;
            } else {
                DB::commit();
                return ['EAN13' => $package->EAN13, 'result' => true];
            }
        } else {
            return false;
        }
    }
}
