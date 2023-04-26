<?php

namespace App\Models;

use App\Models\Product;
use App\Models\OrderLine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductOderLine extends Model
{
    use HasFactory;

    public function orderLine(){
        return $this->belongsTo(OrderLine::class)->withTimeStamps();
    }

    public function product(){
        return $this->hasOne(Psroduct::class)->withTimeStamps();
    }
}
