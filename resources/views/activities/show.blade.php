<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>


img {
  width: 300px;
  height: 200px;
  object-fit: cover;
}
</style>
</head>

<body>
    <h1>{{ $activity->title }}</h1>
    <p>{{ $activity->body }}</p>
    <p>Start Time: {{ $activity->timeStart }}</p>
    <p>End Time: {{ $activity->time_end }}</p>
    <p>Number of Volunteers: {{ $activity->num_vol }}</p>
    <p>Address: {{ $activity->address }}</p>
    <p>Status: {{ $activity->status }}</p>

    @foreach($activity->images as $image)
    <div class="img">
        <img src="{{ $image->image_url }}" alt="Activity Image">
    </div>
    @endforeach
</body>
</html>
