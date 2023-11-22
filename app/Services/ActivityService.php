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

    public function createActivity(array $data, array $images)
    {
        // Validate the data as needed

        // Create the activity
        $activity = Activity::create($data);

        // Upload and associate images
        foreach ($images as $image) {
            $uploadedImage = Cloudinary::upload($image->getRealPath())->getSecurePath();
            $activity->images()->create(['image_url' => $uploadedImage]);
        }

        return $activity;
    }

    public function update ($activityData){

        $activity = Activity::findOrFail($activityData['id']);

        if ($activity) {
            $result = $activity->update($activityData -> all());
            return $result;
        }
        return false;
    }

    public function delete ($id){
        $checkExits = Activity::findOrFail($id);

        if ($checkExits) {
            $result = Activity::destroy($id);;
            return $result;
        }
        return;
    }

    public function getAll($page = 1, $pageSize = null, $status = null)
    {
        $query = Activity::query();
        $pageSize = $pageSize ?? $query->count();
        if ($status !== null) {
            $query->where('status', $status);
        }
        return $query->paginate($pageSize, ['*'], 'page', $page);
    }

    public function getOne ($id){
        $result = Activity::find($id);
        return $result;
    }
}
