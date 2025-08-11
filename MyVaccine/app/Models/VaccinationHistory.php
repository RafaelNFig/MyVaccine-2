<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VaccinationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_cpf',
        'vaccine_id',
        'post_id',
        'batch',
        'application_date',
    ];

    protected $casts = [
        'application_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_cpf', 'cpf');
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
