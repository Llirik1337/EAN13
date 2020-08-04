<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Codedm;
use App\Company;
class Cargo extends Model
{
    public function company() {
        return $this->belongsTo(Company::class);
    }
    public function codedm() {
        return $this->hasMany(Codedm::class);
    }
}
