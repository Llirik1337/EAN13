<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Codedm extends Model
{
    protected $table = 'codedm';

    public  function Status()
    {
        return $this->belongsTo(Statuscodedm::class);
    }

    public function Codeean13()
    {
        return $this->belongsTo(Codeean13::class);
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

    public static function getCodeDmByCodeEan13Id($id)
    {
        \Log::debug('id');
        \Log::debug($id);
        return static::where('codeean13_id', $id)->where('status_id', null)->get()->first();
    }

    public static function getByCodeeanId($codeDm,$codeeanId) {
        Log::debug(__CLASS__);
        Log::debug(__FUNCTION__);
        Log::debug($codeDm);
        Log::debug($codeeanId);
        return static::where('code', $codeDm)->where('codeean13_id',$codeeanId)->get()->first();
    }


    public static function getByCode($code)
    {
        return static::where('code', $code)
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


    public static function getByStatus($codeean13,$status = null)
    {
        if ($status !== null) {
            $codedm = static::where('codeean13_id', $codeean13)->where('status_id','!=', null)->with('status')->get();
            $codedmByStatus = $codedm->filter(function($item) use ($status) {
                if($item !== null && $item->status->name === $status) {
                    return $item;
                }
            });
            return $codedmByStatus;
        } else {
            $codedm = static::where('codeean13_id', $codeean13)->where('status_id', null)->with('status')->get();
            return $codedm;
        }
    }
}
