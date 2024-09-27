<x-app-layout>
    <h1>Rental Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Car: {{ $rental->car->name }}</h5>
            <p class="card-text">Start Date: {{ $rental->start_date }}</p>
            <p class="card-text">End Date: {{ $rental->end_date }}</p>
            <p class="card-text">Total Cost: {{ $rental->total_cost }} USD</p>
            <p class="card-text">Status: {{ $rental->status }}</p>

            <a href="{{ route('user.rental.index') }}" class="btn btn-primary">Back to Rentals</a>
        </div>
    </div>
</x-app-layout>