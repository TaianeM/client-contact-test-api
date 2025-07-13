<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends Model
{
    protected $fillable = [
        'nome',
        'data_nascimento',
        'cpf'
    ];

    public function client(): HasOne
    {
        return $this->hasOne(Contact::class, 'cliente_id');
    }

}
