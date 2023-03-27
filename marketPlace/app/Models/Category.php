<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];


    public function products() {
        return $this->belongsToMany(Product::class)->withTimeStamps();
    }
    
    /**
     * Funcio per obtenir les subCategories
     */
    public static function getSubCategories($parentId){
        return Category::select('name')
        ->where('parent_id', $parentId)->get();
    }
}
