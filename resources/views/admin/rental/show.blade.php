<x-app-layout>
    <div class="container">
        <h1>Update Rental Status</h1>

        <div class="card">
            <div class="card-body">
                <!-- Rental Information -->
                <p><strong>User:</strong> {{ $rental->user->name }}</p>
                <p><strong>Car:</strong> {{ $rental->car->name }} ({{ $rental->car->brand }}, {{ $rental->car->model }})
                </p>
                <p><strong>Start Date:</strong> {{ $rental->start_date }}</p>
                <p><strong>End Date:</strong> {{ $rental->end_date }}</p>
                <p><strong>Total Cost:</strong> ${{ number_format($rental->total_cost, 2) }}</p>
                <p><strong>Current Status:</strong> {{ $rental->status }}</p>

            </div>
        </div>
    </div>
</x-app-layout>