<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Codedm;

class Company extends Model
{
    protected $table = 'company';
    protected $fillable = ['name'];

    public function cargo() {
        return $this->hasMany(Cargo::class);
    }
}
