<!-- resources/views/activities/form.blade.php

@extends('layouts.app')

@section('content')
    <h1>{{ isset($activity) ? 'Edit Activity' : 'Create New Activity' }}</h1>

    @if(isset($activity))
        <form action="{{ route('activities.update', $activity) }}" method="POST">
            @method('PUT')
    @else
        <form action="{{ route('activities.store') }}" method="POST">
    @endif
            @csrf

            <label for="title">Title:</label>
            <input type="text" name="title" value="{{ old('title', isset($activity) ? $activity->title : '') }}" required>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
@endsection -->
