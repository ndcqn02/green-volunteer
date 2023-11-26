<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="{{ route('activities.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>

        <label for="body">Body:</label>
        <textarea name="body" id="body" rows="4" required></textarea>

        <label for="timeStart">Start Time:</label>
        <input type="datetime-local" name="timeStart" id="timeStart" required>

        <label for="time_end">End Time:</label>
        <input type="datetime-local" name="time_end" id="time_end" required>

        <label for="num_vol">Number of Volunteers:</label>
        <input type="number" name="num_vol" id="num_vol" required>

        <label for="address">Address:</label>
        <input type="text" name="address" id="address" required>

        <label for="status">Status:</label>
        <input type="text" name="status" id="status" required>

        <label for="images">Images:</label>
        <input type="file" name="images[]" multiple accept="image/*" required>

        <button type="submit">Submit</button>
    </form>

</body>
</html>
