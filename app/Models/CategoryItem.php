<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryItem extends Model
{
    use HasFactory;

    protected $table = 'category_item';
    protected $guarded = [];
    
    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
