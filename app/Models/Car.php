<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    // Define fillable attributes
    protected $fillable = [
        'name',
        'brand',
        'model',
        'year',
        'car_type',
        'daily_rent_price',
        'availability',
        'image',
    ];


    /**
     * Get the rentals for the car.
     */
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
