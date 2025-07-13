<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    protected $fillable = [
        'cliente_id',
        'tipo',
        'descricao'
    ];


     /**

     * Get the comments for the blog post.
     */
    public function contact(): HasMany
    {
        return $this->hasMany(Client::class, 'id');
    }
}
