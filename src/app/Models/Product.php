<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'image',
        'description',
    ];

    public function seasons()
    {
        return $this->belongsToMany(Season::class, 'product_season');
    }

    public function scopeKeyword(Builder $query, ?string $keyword): Builder
    {
        if (blank($keyword)) {
            return $query;
        }

        return $query->where('name', 'like', '%' . $keyword . '%');
    }

    public function scopeSortPrice(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'high' => $query->orderBy('price', 'desc'),
            'low' => $query->orderBy('price', 'asc'),
            default => $query->orderBy('id'),
        };
    }
}
