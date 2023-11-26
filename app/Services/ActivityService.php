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
    // public function updateActivity(Activity $activity, array $data)
    // {
    //     $activity->update($data);
    //     if (isset($data['images'])) {
    //         foreach ($data['images'] as $images) {
    //             $image = $activity->images()->find($images['activity_id'] == $activity['id']);
    //             if ($image) {
    //                 $image->update(['image_url' => $images['image_url']]);
    //             } else {
    //                 $activity->images()->create(['image_url' => $images['image_url']]);
    //             }
    //         }
    //     }

    //     return $activity;
    // }
    public function updateActivityWithImages(Activity $activity, array $data)
    {
        $activity->update([
            'title' => $data['title'],
            'body' => $data['body'],
            'timeStart' => $data['timeStart'],
            'time_end' => $data['time_end'],
            'num_vol' => $data['num_vol'],
            'address' => $data['address'],
            'status' => $data['status'],
        ]);

        $this->updateImages($activity, $data['images']);

        return $activity->refresh();
    }

    protected function updateImages(Activity $activity, array $images)
    {
        $existingImageIds = collect($images)->pluck('id')->filter()->toArray();
        $activity->images()->whereNotIn('id', $existingImageIds)->delete();

        foreach ($images as $images) {
            $image = $activity->images()->find($images['id']);

            if ($image) {
                // If the image URL has changed, upload the new image to Cloudinary
                if ($image->image_url !== $images['image_url']) {
                    $uploadedImageUrl = $this->uploadImageToCloudinary($images['image_url']);
                    $image->update(['image_url' => $uploadedImageUrl]);
                }
            } else {
                // New image, upload to Cloudinary and associate with the activity
                $uploadedImageUrl = $this->uploadImageToCloudinary($images['image_url']);
                $activity->images()->create(['image_url' => $uploadedImageUrl]);
            }
        }
    }

    protected function uploadImageToCloudinary($imageUrl)
    {
        // Use Cloudinary API to upload the image
        $uploadedImage = Cloudinary::upload($imageUrl, ['folder' => 'images']);

        // Return the Cloudinary URL of the uploaded image
        return $uploadedImage->secure_url;
    }

    public function deleteActivity(Activity $activity)
    {
        $activity->images()->delete();
        $activity->delete();
        return true;
    }



    public function getOne ($id){
        return Activity::with('images')->find($id);
    }

}
