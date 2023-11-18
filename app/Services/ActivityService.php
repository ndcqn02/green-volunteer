<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\JsonResponse;

class ActivityService
{

    public function create ($activity){
        $result = Activity::create($activity ->all());
        return $result;
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

    public function getAll($page = 1, $pageSize = 10, $status = null)
    {
        $query = Activity::query();

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
