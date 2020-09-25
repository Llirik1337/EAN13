<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Packagedm;
use App\Statuscodedm;
use Illuminate\Support\Facades\DB;

class Package extends Model
{

    protected $fillable = ['EAN13'];

    public function status()
    {
        return $this->belongsTo(Statuscodedm::class, 'status_id');
    }

    public function codedms() {
	    return $this->belongsToMany(Codedm::class, 'packagedms');
    }

    public static function findByEan($ean13) {
        return static::where('EAN13', $ean13)->get()->first();
    }

    public static function createPackage($store = false)
    {
        $package = new Package;

        $status = new Statuscodedm;
        $status->name = "New Package";
        $status->save();

        $package->status_id = $status->id;
        $package->save();


        $package->EAN13 = 241000000000 + $package->id;
        $package->store = $store;
        $package->save();
        return $package;
    }

    public static function getByEAN($ean)
    {
        return static::where('EAN13', $ean)->get()->first();
    }

    public static function add($codedms)
    {
        if (count($codedms) > 0) {

            $result = Packagedm::checkDM($codedms);
            if ($result['result']) {
                $package = static::createPackage();
                $package_result = ['EAN13' => $package->EAN13];
                array_push($package_result, Packagedm::add($package->id, $result['codedms']));
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
    public static function store($codedms)
    {
        if (count($codedms) > 0) {

            $package = static::createPackage(true);
            $package_result = ['EAN13' => $package->EAN13];
            array_push($package_result, Packagedm::storeAdd($package->id, $codedms));
            return $package_result;
        } else {
            return false;
        }
    }
}
