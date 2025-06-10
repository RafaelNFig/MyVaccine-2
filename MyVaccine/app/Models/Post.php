<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['name', 'address', 'city', 'state', 'status'];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function vaccinationHistory()
    {
        return $this->hasMany(VaccinationHistory::class);
    }
}