<?php

namespace App\Http\Controllers\User;

use App\Models\Rental;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Mail\RentalCreated;
use App\Mail\RentalCreatedMail;
use Illuminate\Support\Facades\Mail;

class RentalController extends Controller
{
    /**
     * Display a listing of the rentals for the logged-in user.
     */
    public function index()
    {
        $rentals = Rental::where('user_id', Auth::id())->with('car')->get();
        return view('user.rental.index', compact('rentals'));
    }

    /**
     * Show the form for creating a new rental.
     */
    public function create()
    {
        $cars = Car::where('availability', true)->get();

        return view('user.rental.create', compact('cars'));
    }

    /**
     * Store a newly created rental.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',

        ]);


        // Check if the car is available for the requested dates
        $overlappingRentals = Rental::where('car_id', $request->car_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
            })
            ->exists();

        if ($overlappingRentals) {
            return response()->json(['error' => 'Car is already booked for the selected dates.']);
        }

        //get car daily rent price
        $car = Car::findOrFail($request->car_id);
        $totalCost = $car->daily_rent_price * (strtotime($request->end_date) - strtotime($request->start_date)) / 86400;

        $rental = Rental::create([
            'user_id' => Auth::id(),
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_cost' => $totalCost,
            'status' => 'Ongoing',  // Default status is 'pending'
        ]);

        // Send email notification to the user
        Mail::to(Auth::user()->email)->send(new RentalCreatedMail($rental));;

        return redirect()->route('user.rental.index')->with('success', 'Rental created successfully.');
    }

    /**
     * Display the specified rental.
     */
    public function show(string $id)
    {
        $rental = Rental::where('user_id', Auth::id())->with('car')->findOrFail($id);
        return view('user.rental.show', compact('rental'));
    }

    /**
     * Show the form for editing a rental. (Users shouldn't be able to edit rentals.)
     */
    public function edit(string $id)
    {
        // If you want to allow users to view rental details for editing, ensure only certain fields can be updated.
        return redirect()->route('user.rental.index')->withErrors('You cannot edit a rental.');
    }

    /**
     * Update the rental (disabled for users).
     */
    public function update(Request $request, string $id)
    {
        return redirect()->route('user.rental.index')->withErrors('Rental update is not allowed.');
    }

    /**
     * Remove the specified rental (before the start date only).
     */
    public function destroy(string $id)
    {
        $rental = Rental::where('user_id', Auth::id())->findOrFail($id);

        // Allow deletion only if the rental hasn't started yet
        if ($rental->start_date <= now()) {
            return redirect()->back()->withErrors('You cannot delete a rental that has already started.');
        }

        $rental->delete();
        return redirect()->route('user.rental.index')->with('success', 'Rental deleted successfully.');
    }
}
