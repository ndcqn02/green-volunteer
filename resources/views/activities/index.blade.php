<!-- @extends('layouts.app')

@section('content')
    <h1>Activities</h1>
    <form action="{{ route('activities.index') }}" method="GET">
        <div class="form-group">
            <label for="status">Filter by Status:</label>
            <select name="status[]" class="form-control" multiple>
                <option value="active" {{ in_array('approved', request('status', [])) ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ in_array('pending', request('status', [])) ? 'selected' : '' }}>Inactive</option>
                <option value="completed" {{ in_array('pending', request('status', [])) ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Apply Filters</button>
    </form>

    <a href="{{ route('activities.create') }}" class="btn btn-success">Create New Activity</a>

    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
                <tr>
                    <td>{{ $activity->title }}</td>
                    <td>{{ $activity->timeStart }}</td>
                    <td>{{ $activity->time_end }}</td>
                    <td>
                    @if ($activity->images->isNotEmpty())
                        <h2>Images</h2>
                        <div class="row">
                            @foreach ($activity->images as $image)
                                <div class="col-md-3 mb-3">
                                    <img src="{{ $image->image_url }}" alt="Activity Image" class="img-fluid">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No Images</p>
                    @endif

                    </td>
                    <td>
                        <a href="{{ route('activities.show', $activity) }}" class="btn btn-info">View</a>
                        <a href="{{ route('activities.edit', $activity) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('activities.destroy', $activity) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $activities->appends(request()->except('page'))->links() }}
@endsection -->
