<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'cliente_id',
        'tipo',
        'descricao'
    ];


    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'cliente_id');
    }
}
