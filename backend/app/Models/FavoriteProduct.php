<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'product_id', 'title', 'image', 'price', 'review'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'review' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
