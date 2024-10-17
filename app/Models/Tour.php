<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'travel_id',
        'name',
        'starting_date',
        'ending_date',
        'price'

    ];

    public function travel(): BelongsTo
    {
        return $this->belongsTo(Travel::class);
    }

    public function priceInCents(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['price'] / 100
        );
    }

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) =>$value / 100,
            set: fn($value) =>$value * 100,
        );
    }

    public function scopePriceFrom(Builder $query, $price): Builder
    {
        return $query->where('price', '>=', $price * 100);
    }

    public function scopePriceTo(Builder $query, $price): Builder
    {
        return $query->where('price', '<=', $price * 100);
    }

    public function scopeDateFrom(Builder $query, $date): Builder
    {
        return $query->where('starting_date', '>=', $date);
    }

    public function scopeDateTo(Builder $query, $date): Builder
    {
        return $query->where('starting_date', '<=', $date);
    }
}
