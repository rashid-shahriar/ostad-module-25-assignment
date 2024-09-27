<x-app-layout>
    <h1>Manage Cars</h1>
    <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">Add Car</a>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Year</th>
                <th>Car Type</th>
                <th>Daily Rent</th>
                <th>Availability</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cars as $car)
            <tr>
                <td>{{ $car->name }}</td>
                <td>{{ $car->brand }}</td>
                <td>{{ $car->model }}</td>
                <td>{{ $car->year }}</td>
                <td>{{ $car->car_type }}</td>
                <td>{{ $car->daily_rent_price }}</td>
                <td>{{ $car->availability ? 'Available' : 'Not Available' }}</td>
                <td>
                    <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>