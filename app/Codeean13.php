<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Company;
use App\Statuscodedm;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class Codeean13 extends Model
{
    protected $table = 'codeean13';

    protected $fillable = [
        'code'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function cargo()
    {
        return $this->belongsToMany(Cargo::class, 'codeean13_cargos');
    }

    public function codedm() {
        return $this->hasMany(Codedm::class);
    }
    public function codedmDoesntHaveCargo() {
        return $this->hasMany(Codedm::class)->where('cargo_id',null);
    }

    public static function getByCode($code, $cargo_id = null)
    {
        Log::debug(__CLASS__);
        Log::debug(__FUNCTION__);
        Log::debug($cargo_id);
        $ean = static::where('code','like', $code.'%')->where('company_id', Auth::user()->company->id)->get()->first();

        if($ean && $cargo_id) {
            $codes = $ean->codedm()->where('cargo_id', $cargo_id)->get();
            Log::debug(json_encode($codes));
        }
        Log::debug(json_encode($ean));
        return $ean;
    }

    public static function getAllCodedm($codeean) {
        return static::where('code', $codeean)->where('company_id', Auth::user()->company->id)->get()->all();
    }

    public static function add($code, $tovar = null, $company = null)
    {
//        \Log::debug(__CLASS__ . "->" . __FUNCTION__);
        $codeean13 = static::firstOrCreate(['code' => $code]);
        if ($tovar !== null)
            $codeean13->tovarname = $tovar;
        if ($company !== null && $codeean13->company_id === null)
            $codeean13->company_id = Company::firstOrCreate(['name' => $company])->id;
//        \Log::debug(json_encode($codeean13));
        $codeean13->save();
        return $codeean13;
    }

    public static function getStatisticByCodeeanId($id, $cargo_id = null)
    {
        Log::debug(__CLASS__);
        Log::debug(__FUNCTION__);
        Log::debug($cargo_id);
        return [
            'free' => Codedm::getByStatus($id,null,$cargo_id)->count(),
            'printed' =>  Codedm::getByStatus($id, 'Print',$cargo_id)->count(),
            'inflicted' => Codedm::getByStatus($id, 'Inflicted',$cargo_id)->count(),
            'package' =>  Codedm::getByStatus($id, 'Package',$cargo_id)->count(),
            'invoice' => Codedm::getByStatus($id, 'Invoice',$cargo_id)->count(),
        ];
    }

    public static function getAllDMByStatus($status = null,$cargo_id=null) {
        $eancodes = static::where('company_id', Auth::user()->company->id)->get()->all();
        $result = [];
        foreach ($eancodes as $eancode) {
            $codedms =  Codedm::getByStatus($eancode->id, $status,$cargo_id);
            if(count($codedms))
                array_push($result,['codes'=>$codedms, 'eancode'=>$eancode]);
        }
        return $result;
    }

    public static function updateCode($old_code, $new_code)
    {
        try {
            $code = static::where('code', $old_code)->get()->first();
            if ($code === null) {
                return false;
            }
            $code->code = $new_code;
            $code->save();
            return true;
        } catch(\Exception $exception) {
            return false;
        }
    }

    public static function getStatisticsByCompanyId($company_id, $cargo_id = null)
    {
        Log::debug(__CLASS__);
        Log::debug(__FUNCTION__);
        $codeean13 = static::where('company_id', $company_id)->whereHas('codedm',function (Builder $query) use ($cargo_id) {
           return $query->where('cargo_id', $cargo_id);
        })->get();
        Log::debug(json_encode($codeean13));

            $result = $codeean13->map(function ($item) use ($cargo_id) {
                if ($item !== null) {
                    $statistic = static::getStatisticByCodeeanId($item->id, $cargo_id);
                    $item['statistics'] = $statistic;
                    return $item;
                }
            });
            return $result;
    }
}
