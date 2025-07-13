<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'nome',
        'data_nascimento',
        'cpf'
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'cliente_id');
    }
}
