<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomType extends Model
{
    use HasFactory;

    // by default laravel has timestamp
    public $timestamps = false;

    protected $fillable = [
        'type'
    ];

    // or use $guard to replace $fillable but $guard is for blacklist, unless you accept everything
    // protected $guarded = [];

    protected $appends = [
        'uppercase_name'
    ];

    protected $hidden = [
        'id'
    ];

    protected $attributes = [
        'type' => 'rando'
    ];

    public function getUppercaseNameAttribute()
    {
        return strtoupper(($this->type));
    }
}