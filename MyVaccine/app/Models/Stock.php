<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = ['post_id', 'vaccine_id', 'quantity', 'batch', 'expiration_date'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class);
    }
}