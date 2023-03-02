<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producte extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'selled_at',
    ];

    public function categoria() {
        return $this->belongsToMany(Categoria::class);
    }
}
