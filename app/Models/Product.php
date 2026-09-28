<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // 1. Import Attribute

class Product extends Model
{
    protected $fillable = ['category_id', 'code', 'name', 'unit', 'price', 'stock', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // 2. Tambahkan Accessor untuk format Rupiah
    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => 'Rp ' . number_format($attributes['price'] ?? 0, 0, ',', '.')
        );
    }
}
