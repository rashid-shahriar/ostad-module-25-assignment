<x-app-layout>
    <h1>Rent a Car</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('user.rental.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="car_id">Select Car</label>
            <select name="car_id" class="form-control" required>
                <option value="">Select Car</option>
                @foreach ($cars as $car)
                <option value="{{ $car->id }}">{{ $car->name }} ({{ $car->daily_rent_price }} USD/day)</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Rental</button>
    </form>

</x-app-layout>