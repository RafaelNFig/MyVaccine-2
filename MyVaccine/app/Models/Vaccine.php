<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vaccine extends Model
{
    use HasFactory;

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'name',
        'min_age',
        'max_age',
        'contraindications',
    ];

    // Relacionamento 1:N com Stock
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    // Relacionamento 1:N com VaccinationHistory
    public function vaccinationHistory()
    {
        return $this->hasMany(VaccinationHistory::class);
    }
}