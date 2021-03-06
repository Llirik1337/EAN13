<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Package;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;
use Illuminate\Support\Facades\Log;

class Boxean13 extends Model
{
    protected $fillable = [
        'package_id',
        'boxes_id'
    ];

    public function package()
    {
        $this->belongsTo(Package::class, 'packages_id', 'id');
    }


    public static function checkEAN13($code)
    {
        $result = [];
        $errors = [];
        if (count($code) > 0) {
            foreach ($code as $codedm_item) {
                $package = Package::getByEAN($codedm_item['codeean13']);
                Log::debug("!!!!!!!!!@@@@@");
		        Log::debug(json_encode($package->codedms));
                $isExist = false;
                if($package !== null) {
                    $isExist = static::where('packages_id', $package->id)->get()->first() !== null;
                } else if ($package === null) {
                    array_push($errors, ['msg' => 'Can\'t not find EAN code', 'Package' => $codedm_item['codeean13']]);
                }
                 if($isExist) {
                    array_push($errors, ['msg' => 'EAN code was previously added', 'Package' => $package]);
                }
                else {
                    foreach ($package->codedms as $code) {
                        Log::debug(json_encode($code));
                        $status = $code->status;
                        $status->name = 'Boxed';
                        $status->save();
                        Log::debug(json_encode($status));
                        Log::debug(json_encode($code));
                    }
                    array_push($result, $package);
                }
            }
            return ['errors' => $errors, 'codeean13' => $result, 'result' => count($errors) > 0 ? false : true];
        } else {
            return ['msg' => "none codeean13", 'result' => false];
        }
    }

    public static function getByBoxId($box_id)
    {
        return static::where('boxes_id', $box_id)->get();
    }

    public static function add($box_id,$codes)
    {
        \Log::debug('$codedms');
        \Log::debug(json_encode($codes));
        \Log::debug('$package_id');
        \Log::debug($box_id);

        $result = ['result'=> true, 'packagedms' => []];
        foreach ($codes as $item) {
            $Box = new Boxean13;
            $Box->boxes_id = $box_id;
            $Box->packages_id = $item->id;
            $Box->save();
            array_push($result['packagedms'], $Box);

        }

        \Log::debug('result');
        \Log::debug(json_encode($result));
        return $result;
    }
}
