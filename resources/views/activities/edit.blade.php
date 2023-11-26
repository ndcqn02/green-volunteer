<!-- resources/views/activities/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Edit Activity</h1>

    <form action="{{ route('activities.update', $activity) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $activity->title) }}">
        </div>

        <div class="form-group">
            <label for="body">Body:</label>
            <textarea name="body" class="form-control">{{ old('body', $activity->body) }}</textarea>
        </div>

        <div class="form-group">
            <label for="timeStart">Start Time:</label>
            <input type="datetime-local" name="timeStart" class="form-control" value="{{ old('timeStart', \Carbon\Carbon::parse($activity->timeStart)->format('Y-m-d\TH:i:s')) }}">
        </div>

        <div class="form-group">
            <label for="time_end">End Time:</label>
            <input type="datetime-local" name="time_end" class="form-control" value="{{ old('time_end', \Carbon\Carbon::parse($activity->time_end)->format('Y-m-d\TH:i:s')) }}">
        </div>

        <div class="form-group">
            <label for="num_vol">Number of Volunteers:</label>
            <input type="number" name="num_vol" class="form-control" value="{{ old('num_vol', $activity->num_vol) }}">
        </div>

        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $activity->address) }}">
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <input type="text" name="status" class="form-control" value="{{ old('status', $activity->status) }}">
        </div>

        <div class="form-group">
            <label for="images">Existing Images:</label>
            @foreach ($activity->images as $index => $image)
                <input type="hidden" name="images[{{ $index }}][id]" value="{{ $image->id }}">
                <input type="text" name="images[{{ $index }}][image_url]" class="form-control" placeholder="Image URL {{ $index + 1 }}" value="{{ old("images.$index.image_url", $image->image_url) }}">
            @endforeach
        </div>

        <div class="form-group">
            <label for="new_images">New Images:</label>
            <input type="file" name="new_images[]" class="form-control-file" multiple>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
