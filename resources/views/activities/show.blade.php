@extends('layouts.app')

@section('content')
    <h1>Activity Details</h1>

    <p><strong>Title:</strong> {{ $activity->title }}</p>
    <p><strong>Start Time:</strong> {{ $activity->timeStart }}</p>
    <p><strong>End Time:</strong> {{ $activity->time_end }}</p>

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



    <a href="{{ route('activities.index') }}" class="btn btn-secondary">Back to Activities</a>
@endsection
