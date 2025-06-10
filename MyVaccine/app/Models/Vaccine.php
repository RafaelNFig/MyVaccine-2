<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    protected $fillable = ['name', 'min_age', 'max_age', 'contraindications'];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function vaccinationHistory()
    {
        return $this->hasMany(VaccinationHistory::class);
    }
}