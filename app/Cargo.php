<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Codedm;
use App\Company;
use Illuminate\Support\Facades\Log;

class Cargo extends Model
{
    protected $fillable = ['number'];
    public function company() {
        return $this->belongsTo(Company::class);
    }
    public function codedm() {
        return $this->hasMany(Codedm::class);
    }

    public function codeean() {
        return $this->belongsToMany(Codeean13::class, 'codeean13_cargos');
    }
    public static function addNewCodedm($data) {
        $errors = [];
        foreach ($data as $datum ){
            $codedm = Codedm::getByCode($datum['code']);
            if(!$codedm || ($codedm->status !== null || $codedm->cargo_id !== null)) {
                array_push($errors, [$datum]);
            } else {
                $ean = $codedm->codeean13;
                $cargo = static::firstOrCreate(['number' => $datum['number'], 'codeean13_id' => $ean->id], ['number' => $datum['number'], 'codeean13_id' => $ean->id]);
                $codedm->cargo_id = $cargo->id;
                $codedm->save();
            }
        }
        Log::debug(json_encode($errors));
        return $errors;
    }
}
