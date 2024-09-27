<x-app-layout>
    <h1>Manage Rentals</h1>
    <a href="{{ route('admin.rental.create') }}" class="btn btn-primary">Add Rental</a>


    <table class="table">
        <thead>
            <tr>
                <th>Car</th>
                <th>User</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Cost</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rentals as $rental)
            <tr>
                <td>{{ $rental->car->name }}</td>
                <td>{{ $rental->user->name }}</td>
                <td>{{ $rental->start_date }}</td>
                <td>{{ $rental->end_date }}</td>
                <td>{{ $rental->total_cost }}</td>
                <td>{{ $rental->status }}</td>
                <td>
                    <a href="{{ route('admin.rental.edit', $rental->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('admin.rental.show', $rental->id) }}" class="btn btn-info">View</a>
                    <form action="{{ route('admin.rental.destroy', $rental->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <form action="{{ route('admin.rental.updateStatus', $rental->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        <select name="status" onchange="this.form.submit()">
                            <option value="Ongoing" {{ $rental->status == 'Ongoing' ? 'selected' : '' }}>Ongoing
                            </option>
                            <option value="Completed" {{ $rental->status == 'Completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="Canceled" {{ $rental->status == 'Canceled' ? 'selected' : '' }}>Canceled
                            </option>
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>