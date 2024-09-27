<x-app-layout>
    <h1>Your Rentals</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if ($rentals->isEmpty())
    <p>You have no rentals.</p>
    @else

    <a href="{{ route('user.rental.create') }}" class="btn btn-primary">Rent a Car</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Car</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Cost</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rentals as $rental)
            <tr>
                <td>{{ $rental->car->name }}</td>
                <td>{{ $rental->start_date }}</td>
                <td>{{ $rental->end_date }}</td>
                <td>{{ $rental->total_cost }} USD</td>
                <td>{{ $rental->status }}</td>
                <td>
                    <a href="{{ route('user.rental.show', $rental->id) }}" class="btn btn-info">View</a>
                    @if ($rental->start_date > now())
                    <form action="{{ route('user.rental.destroy', $rental->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</x-app-layout>