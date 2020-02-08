<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Statuscodedm;
use App\Codeean13;

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

    public static function getCodeDmByCodeEan13Id($id)
    {
        \Log::debug('id');
        \Log::debug($id);
        return static::where('codeean13_id', $id)->where('status_id', null)->get()->first();
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
        // \Log::debug($status);
        if ($status !== null) {
            $codedm = static::where('codeean13_id', $codeean13)->where('status_id','!=', null)->with('status')->get();
            // \Log::debug($codedm);
            $codedmByStatus = $codedm->filter(function($item) use ($status) {

                if($item !== null && $item->status->name === $status) {
                    return $item;
                }
            });
            // \Log::debug('codedmByStatus');
            // \Log::debug($codedmByStatus->count());
            return $codedmByStatus->count();
        } else {
            $codedm = static::where('codeean13_id', $codeean13)->where('status_id', null)->with('status')->get();
            return $codedm->count();
            // \Log::debug($codedm->count());
        }
    }
}
