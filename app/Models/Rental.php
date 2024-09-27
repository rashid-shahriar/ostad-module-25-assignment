<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    // Define fillable attributes
    protected $fillable = [
        'user_id',
        'car_id',
        'start_date',
        'end_date',
        'total_cost',
        'status',
    ];

    /**
     * Get the car associated with the rental.
     */
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Get the user associated with the rental.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
