<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $incrementing = false;
    protected $keyType = 'integer';
    protected $fillable = ['id', 'city_id', 'name'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}

