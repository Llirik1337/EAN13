<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statuscodedm extends Model
{
    //
    protected $table = 'statuscodedm';

    protected $fillable = ['name'];

    public static function setStatus($id, $statusText) {
        $status = static::find($id);
        $status->name = $statusText;
        $status->save();
        return $status;
    }
}
