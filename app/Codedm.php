<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;

class Codedm extends Model
{
    protected $table = 'codedm';

    public  function status()
    {
        return $this->belongsTo(Statuscodedm::class);
    }

    public function codeean13()
    {
        return $this->belongsTo(Codeean13::class);
    }
    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public static function setStatus($id, $textStatus = 'Print') {
        Log::debug(__CLASS__);
        Log::debug(__FUNCTION__);
        Log::debug($id);
        $codedm = static::where('id',$id)->get()->first();
        if(!$codedm->status_id) {
            $status = $codedm->Status()->create(['name' => $textStatus]);
            $status->save();
            $codedm->status_id = $status->id;
        } else {
            $status = Statuscodedm::find($codedm->status_id);
            $status->name = $textStatus;
            $status->save();
        }
        \Log::debug('status');
        \Log::debug($status);

        $codedm->save();
    }

    public static function getCodeDmByCodeEan13Id($id, $cargo_id = null)
    {
        return static::where('codeean13_id', $id)->where('status_id', null)->where('cargo_id', $cargo_id)->get()->first();
    }

    public static function getByCodeeanId($codeDm,$codeeanId) {
        Log::debug(__CLASS__);
        Log::debug(__FUNCTION__);
        Log::debug($codeDm);
        Log::debug($codeeanId);
        return static::where('code','like', $codeDm.'%')->where('codeean13_id','like',$codeeanId.'%')->get()->first();
    }


    public static function getByCode($code)
    {
        return static::where('code','like', $code.'%')
            // ->where('status_id','!=', null)
            ->with(['status', 'codeean13'])
            ->get()
            ->first();
    }


    public static function add($code, $codeean13)
    {
        $codedm = static::where('code', $code)->get()->first();
        if ($codedm !== null)
            return false;

        $codedm = new Codedm;
        $codedm->code = $code;
        $codedm->codeean13_id = Codeean13::add($codeean13)->id;
        $codedm->save();
        \Log::debug('$codedm');
        \Log::debug($codedm);
        return $codedm;
    }


    public static function getByStatus($codeean13,$status = null,$cargo_id=null, $count=null)
    {
        Log::debug(__CLASS__);
        Log::debug(__FUNCTION__);
        Log::debug($cargo_id);
        Log::debug($count);
        $codedm = static::where('codeean13_id', $codeean13);

        if($status) {
            $codedm->whereHas('status', function (Builder $query) use ($status) {
                return $query->where('name', $status);
            });
        }
        else {
            $codedm->doesntHave('status');
        }
        $codedm = $codedm->where('cargo_id', $cargo_id);
        if($count) {
            $codedm->limit($count);
        }
        $result = $codedm->get();
        Log::debug(json_encode($result));
        return $result;
    }
}
