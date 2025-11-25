<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'parent_id',
    ];

    public function products(){
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    // 親カテゴリーを取得
    public function parent(){
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    // 子カテゴリーを取得
    public function children(){
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }
}
