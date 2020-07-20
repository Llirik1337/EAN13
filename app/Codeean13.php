<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Company;
use Illuminate\Support\Facades\Log;

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


    public static function getByCode($code)
    {
        \Log::debug('getByCode');

        return static::where('code', $code)->where('company_id', Auth::user()->company->id)->get()->first();
    }

    public static function getAllCodedm($codeean) {
        return static::where('code', $codeean)->where('company_id', Auth::user()->company->id)->get()->all();
    }

    public static function add($code, $tovar = null, $company = null)
    {
        \Log::debug(__CLASS__ . "->" . __FUNCTION__);
        $codeean13 = static::firstOrCreate(['code' => $code]);
        if ($tovar !== null)
            $codeean13->tovarname = $tovar;
        if ($company !== null && $codeean13->company_id === null)
            $codeean13->company_id = Company::firstOrCreate(['name' => $company])->id;
        \Log::debug(json_encode($codeean13));
        $codeean13->save();
        return $codeean13;
    }

    public static function getStatisticByCodeeanId($id)
    {
        return [
            'free' => Codedm::getByStatus($id)->count(),
            'printed' => Codedm::getByStatus($id, "Print")->count(),
            'inflicted' => Codedm::getByStatus($id, "Inflicted")->count(),
            'package' => Codedm::getByStatus($id, "Package")->count(),
            'invoice' => Codedm::getByStatus($id, "Invoice")->count(),
        ];
    }

    public static function getAllDMByStatus($status = null) {
        Log::debug(__CLASS__);
        Log::debug(__FUNCTION__);
        $eancodes = static::where('company_id', Auth::user()->company->id)->get()->all();
        $result = [];
        foreach ($eancodes as $eancode) {
            Log::debug(json_encode($eancode));
            $codedms =  Codedm::getByStatus($eancode->id, $status);
            if(count($codedms))
                array_push($result,['eancode'=>$eancode->code,'codes'=>$codedms, 'tovarName'=>$eancode->tovarname]);
        }
        Log::debug(json_encode($result));
        return $result;
    }

    public static function updateCode($old_code, $new_code)
    {
        $code = static::where('code', $old_code)->get()->first();
        if ($code === null) {
            return false;
        }
        $code->code = $new_code;
        $code->save();
        return true;
    }

    public static function getStatisticsByCompanyId($company_id)
    {
        \Log::debug($company_id);
        $codeean13 = static::where('company_id', $company_id)->get();
        $result = $codeean13->map(function ($item) {
            if ($item !== null) {
                \Log::debug($item->id);
                $statistic = static::getStatisticByCodeeanId($item->id);
                \Log::debug($statistic);
                $item['statistics'] = $statistic;
                return $item;
            }
        });
        \Log::debug('$codeean13 result');
        \Log::debug($result);
        return $result;
    }
}
