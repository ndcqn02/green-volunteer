<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\JsonResponse;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Validation\Rules\ImageFile;

class ActivityService
{
    public function createActivity(array $data, $images)
    {

        $activity = Activity::create($data);
        foreach ($images as $image) {
            $uploadedImage = Cloudinary::upload($image->getRealPath())->getSecurePath();
            $activity->images()->create(['image_url' => $uploadedImage, 'activity_id' => $activity->id]);
        }
        return $activity;
    }

    public function getPaginatedActivities($pageSize = null, $page = null, $title = null, $status = null, $address = null)
    {
        $query = Activity::with('images');
        $pageSize = $pageSize ?? $query->count();
        if ($title !== null) {
            $query->where('title', $title);
        }
        if ($address !== null) {
            $query->where('address', $address);
        }
        if ($status !== null) {
            $query->where('status', $status);
        }
        return $query->paginate($pageSize, ['*'], 'page', $page);
    }

    public function updateActivity($data)
    {
        $activities = Activity::findOrFail($data['id']);

        if ($activities) {
            $result = $activities->update($data->All());
            return $result;
        }
        return false;
    }

    public function deleteActivity($id)
    {
        $activity = Activity::find($id);

        if ($activity) {
            $activity->images()->delete();
            $activity->delete();
            return $activity;
        }
        return false;
    }

    public function getOne($id)
    {
        return Activity::with('images')->find($id);
    }

}
