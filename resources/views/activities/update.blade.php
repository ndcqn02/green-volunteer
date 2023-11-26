<!-- resources/views/activities/update.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Edit Activity</h1>

    <form action="{{ route('activities.update', $activity) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="images">Images:</label>
            <input type="hidden" name="images[0][id]" value="{{ $activity->images[0]->id ?? null }}">
            <input type="text" name="images[0][image_url]" class="form-control" placeholder="Image URL 1" value="{{ $activity->images[0]->image_url ?? '' }}">
            <input type="hidden" name="images[1][id]" value="{{ $activity->images[1]->id ?? null }}">
            <input type="text" name="images[1][image_url]" class="form-control" placeholder="Image URL 2" value="{{ $activity->images[1]->image_url ?? '' }}">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
