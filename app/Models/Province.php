<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    // Matikan auto-increment
    public $incrementing = false;

    // Tipe primary key integer
    protected $keyType = 'integer';

    // Bisa diisi id dan name
    protected $fillable = ['id', 'name'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
