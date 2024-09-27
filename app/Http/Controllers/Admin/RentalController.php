<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rental;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rentals = Rental::with(['car', 'user'])->get();
        return view('admin.rental.index', compact('rentals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user)
    {
        $cars = Car::where('availability', true)->get();
        $users = User::where('role', 'user')->get();

        return view('admin.rental.create', compact('cars', 'users'));
    }

    /**
     * Store a newly created rental in storage.
     */
    public function store(Request $request, Car $car)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date'
        ]);

        // Ensure car is available for the requested dates
        $overlappingRentals = Rental::where('car_id', $request->car_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
            })
            ->exists();


        if ($overlappingRentals) {
            return response('Car is already booked for the selected dates.', 400);
        }

        //get car daily rent price
        $car = Car::findOrFail($request->car_id);
        $totalCost = $car->daily_rent_price * (strtotime($request->end_date) - strtotime($request->start_date)) / 86400;

        Rental::create([
            'user_id' => $request->user_id,
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_cost' => $totalCost,
            'status' => 'Ongoing', // Status defaults to 'pending'
        ]);

        return redirect()->route('admin.rental.index')->with('success', 'Rental created successfully.');
    }

    /**
     * Display the specified rental.
     */
    public function show(string $id)
    {
        $rental = Rental::with(['car', 'user'])->findOrFail($id);
        return view('admin.rental.show', compact('rental'));
    }

    /**
     * Show the form for editing the specified rental.
     */
    public function edit(string $id)
    {
        $rental = Rental::findOrFail($id);
        $cars = Car::where('availability', true)->get();
        $users = User::where('role', 'customer')->get();
        return view('admin.rental.edit', compact('rental', 'cars', 'users'));
    }

    /**
     * Update the specified rental.
     */
    public function update(Request $request, string $id)
    {
        $rental = Rental::findOrFail($id);

        // Ensure car is available for the requested dates
        $overlappingRentals = Rental::where('car_id', $request->car_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date]);
            })->where('id', '!=', $rental->id)    // Exclude the current rental
            ->exists();

        if ($overlappingRentals) {
            return response('Car is already booked for the selected dates.', 400);
        }

        $rental->update($request->all());


        return redirect()->route('admin.rental.index')->with('success', 'Rental updated successfully.');
    }


    /**
     * Update status of the specified rental.
     */

    public function updateStatus(Request $request, string $id)
    {

        $rental = Rental::findOrFail($id);
        // Validate the status input
        $validatedData = $request->validate([
            'status' => 'required|in:Completed,Canceled',
        ]);

        // Update the status
        $rental->update([
            'status' => $validatedData['status'],
        ]);

        return redirect()->route('admin.rental.index')->with('success', 'Rental status updated successfully.');
    }


    /**
     * Remove the specified rental from storage.
     */
    public function destroy(string $id)
    {
        $rental = Rental::findOrFail($id);

        if ($rental->status === 'Completed') {
            return redirect()->route('admin.rental.index')->with('error', 'Cannot delete completed rental.');
        }

        $rental->delete();

        return redirect()->route('admin.rental.index')->with('success', 'Rental deleted successfully.');
    }
}
