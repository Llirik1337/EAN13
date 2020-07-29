<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Company;
use App\UserType;
// use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',  'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    // protected $with = [
    //     'company'
    // ];

    protected $casts = [];

    // protected $with = [
    //     'company'
    // ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function user_types()
    {
        return $this->belongsTo(UserType::class, 'user_types_id', 'id');
    }

    public static function createUser($login, $password, $company, $right = 'user')
    {
        $user = static::where('name', $login)->get()->first();
        if($user === null) {

            $compnay_result = Company::firstOrCreate(['name'=> $company]);
//            \Log::debug('company');

            $compnay_result->name = $company;
            $compnay_result->save();
//            \Log::debug($compnay_result);
            $right =UserType::where('name', $right)->get()->first();
//            \Log::debug('right');
//            \Log::debug($right);
            $user = new User;
            $user->name = $login;
            $user->password = bcrypt($password);
            $user->company_id = $compnay_result->id;
            $user->user_types_id = $right->id;
            $user->save();
            return $user;
        } else {
            return false;
        }
        // $user = static::firstOrCreate(['name'=> $login]);
    }
}
