<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Boxean13;
class Box extends Model
{
    protected $fillable = ['EAN13'];

    public static function createBox()
    {
        $Box = new Box;
        $Box->save();
        $Box->EAN13 = 242000000000 + $Box->id;
        $Box->save();
        return $Box;
    }

    public static function add($codeean13)
    {

        \Log::debug('codeean13');
        \Log::debug($codeean13);

        if (count($codeean13) > 0) {

            $result = Boxean13::checkEAN13($codeean13);
            // \Log::debug('result');
            // \Log::debug($result);
            if ($result['result']) {
                $package = static::createBox();
                $package_result = ['EAN13'=> $package->EAN13];
                array_push($package_result,Boxean13::add($package->id, $result['codeean13']));
                return $package_result;
            } else {
                return $result;
            }
        } else {
            return false;
        }
    }
}
