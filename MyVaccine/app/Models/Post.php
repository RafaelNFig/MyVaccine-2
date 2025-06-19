<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

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