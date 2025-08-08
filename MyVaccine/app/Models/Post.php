<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'city', 'state', 'status'];

    // Define valores padrão para atributos do model
    protected $attributes = [
        'status' => 'ativo',
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function vaccinationHistory()
    {
        return $this->hasMany(VaccinationHistory::class);
    }
}
