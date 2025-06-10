<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // se for usar autenticação Laravel
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'cpf';       // CPF é a chave primária
    public $incrementing = false;        // Não é auto-incremento
    protected $keyType = 'string';       // É string

    protected $fillable = [
        'cpf', 'role', 'name', 'password', 'email', 'dob', 'address', 'telephone',
    ];

    protected $hidden = ['password'];

    // Relação com histórico de vacinação
    public function vaccinationHistory()
    {
        return $this->hasMany(VaccinationHistory::class, 'user_cpf', 'cpf');
    }
}