<x-app-layout>
    <h1>Edit Rental</h1>

    <form action="{{ route('admin.rental.update', $rental->id) }}" method="POST">
        @csrf
        @method('POST')

        <div class="form-group">
            <label for="car_id">Car</label>
            <select name="car_id" class="form-control">
                @foreach ($cars as $car)
                <option value="{{ $car->id }}" {{ $car->id == $rental->car_id ? 'selected' : '' }}>{{ $car->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ $rental->start_date }}">
        </div>

        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ $rental->end_date }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Rental</button>
    </form>
</x-app-layout>