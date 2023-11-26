<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\JsonResponse;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class ActivityService
{
    protected function associateImages(Activity $activity, array $images)
    {
        foreach ($images as $image) {
            $uploadedImage = Cloudinary::upload($image->getRealPath())->getSecurePath();
            $activity->images()->create(['image_url' => $uploadedImage]);
        }
    }
    public function createActivity(array $data, array $images)
    {
        $activity = Activity::create($data);
        $this->associateImages($activity, $images);
        return $activity;
    }
    public function getPaginatedActivities($pageSize = null, $page = null, $status = null, $address = null )
    {
        $query = Activity::with('images');
        $pageSize = $pageSize ?? $query->count();
        if ($address !== null) {
            $query->where('address', $address);
        }
        if ($status !== null) {
            $query->where('status', $status);
        }
        return $query->paginate($pageSize, ['*'], 'page', $page);
    }

    public function updateActivity(Activity $activity, array $data)
    {
        $activity->update($data);
        if (isset($data['images'])) {
            foreach ($data['images'] as $imageData) {
                $image = $activity->images()->find($imageData['id']);
                if ($image) {
                    $image->update(['image_url' => $imageData['image_url']]);
                } else {
                    $activity->images()->create(['image_url' => $imageData['image_url']]);
                }
            }
        }

        return $activity;
    }

    public function deleteActivity(Activity $activity)
    {
        $activityId = Activity::find($activity);

        if ($activityId) {
            $activity->images()->delete();
            $activity->delete();
            return $activity;
        }
        return false;
    }

    public function getOne ($id){
        return Activity::with('images')->find($id);
    }

}
