<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

/**
 * Store list of Teachers
 */
class Teacher extends Model
{
    use HasFactory;

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
    public function SetPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Accessor function
    public function getUpperNameAttribute()
    {
        return strtoupper($this->name);
    }
}
