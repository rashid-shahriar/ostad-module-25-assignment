<x-app-layout class="container">
    <h1>Edit Car</h1>
    <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="mb-3">
            <label for="name" class="form-label">Car Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $car->name }}" required>
        </div>
        <div class="mb-3">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" class="form-control" id="brand" name="brand" value="{{ $car->brand }}" required>
        </div>
        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <input type="text" class="form-control" id="model" name="model" value="{{ $car->model }}" required>
        </div>
        <div class="mb-3">
            <label for="year" class="form-label">Year of Manufacture</label>
            <input type="number" class="form-control" id="year" name="year" value="{{ $car->year }}" required>
        </div>
        <div class="mb-3">
            <label for="car_type" class="form-label">Car Type</label>
            <input type="text" class="form-control" id="car_type" name="car_type" value="{{ $car->car_type }}" required>
        </div>
        <div class="mb-3">
            <label for="daily_rent_price" class="form-label">Daily Rent Price</label>
            <input type="number" step="0.01" class="form-control" id="daily_rent_price" name="daily_rent_price"
                value="{{ $car->daily_rent_price }}" required>
        </div>
        <div class="mb-3">
            <label for="availability" class="form-label">Availability Status</label>
            <select class="form-select" id="availability" name="availability" required>
                <option value="1" {{ $car->availability ? 'selected' : '' }}>Available</option>
                <option value="0" {{ !$car->availability ? 'selected' : '' }}>Not Available</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Car Image</label>
            <input type="file" class="form-control" id="image" name="image">
            <small>Leave blank if you don't want to change the image.</small>
        </div>
        <button type="submit" class="btn btn-primary">Update Car</button>
    </form>
</x-app-layout>