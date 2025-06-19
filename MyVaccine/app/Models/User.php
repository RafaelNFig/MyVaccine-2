<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Para autenticação
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable; // Adicione HasFactory para usar factories

    // Definindo a chave primária como 'cpf'
    protected $primaryKey = 'cpf';

    // Indica que a chave primária não é auto-incrementável
    public $incrementing = false;

    // Tipo da chave primária
    protected $keyType = 'string';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'cpf',
        'role',
        'name',
        'password',
        'email',
        'dob',
        'address',
        'telephone',
    ];

    // Campos ocultos ao serializar o modelo (ex: JSON)
    protected $hidden = [
        'password',
        'remember_token', // caso use autenticação Laravel padrão
    ];

    // Relacionamento 1:N com VaccinationHistory
    public function vaccinationHistory()
    {
        return $this->hasMany(VaccinationHistory::class, 'user_cpf', 'cpf');
    }

    // Opcional: se quiser definir mutator para hashear senha ao setar
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}