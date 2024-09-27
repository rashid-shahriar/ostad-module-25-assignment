<x-app-layout>
    <h1>Create Rental</h1>

    <form action="{{ route('admin.rental.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="user_id">Customer</label>
            <select name="user_id" class="form-control">
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="car_id">Car</label>
            <select name="car_id" class="form-control">
                @foreach ($cars as $car)
                <option value="{{ $car->id }}">{{ $car->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" class="form-control">
        </div>

        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Create Rental</button>
    </form>
</x-app-layout>