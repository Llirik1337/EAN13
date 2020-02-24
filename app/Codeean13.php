<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Company;

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
        // \Log::debug($id);
        return [
            'free' => Codedm::getByStatus($id),
            'printed' => Codedm::getByStatus($id, "Print"),
            'inflicted' => Codedm::getByStatus($id, "Inflicted"),
            'package' => Codedm::getByStatus($id, "Package"),
            'invoice' => Codedm::getByStatus($id, "Invoice"),
        ];
    }

    public static function getStatisticsByCompnayId($company_id)
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
