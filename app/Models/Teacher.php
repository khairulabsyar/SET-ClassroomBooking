<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


/**
 * Store list of Teachers
 */
class Teacher extends AuthUser
{
    use HasFactory, HasApiTokens, HasRoles;
    // Notifiable; // need email column inside Teacher table

    protected $fillable = [
        'name',
        'password',
    ];

    // since there is column name in DB need to do this
    protected $appends = [
        'upper_name'
    ];
    protected $hidden = [
        // 'password',
        'remember_token',
    ];

    // Mutator function
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Accessor function
    public function getUpperNameAttribute()
    {
        return strtoupper($this->name);
    }

    // for relationship, naming convention should be plural of the model related to this model
    public function classroom()
    {
        return $this->hasMany(Classroom::class, 'teachers_id');
    }

    public function profile()
    {
        return $this->morphOne(Profile::class, 'profileable');
    }
}