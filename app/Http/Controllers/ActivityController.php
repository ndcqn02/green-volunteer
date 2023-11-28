<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Services\ActivityService;
use App\Http\Requests\Activity\CreateActivityRequest;
use Illuminate\Http\JsonResponse;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Activity;


class ActivityController extends Controller
{


    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }
    public function index(Request $request)
    {
        $page = $request->input('page');
        $pageSize = $request->input('pageSize');
        $status = $request->input('status');
        $address = $request->input('address');

        $activity = $this->activityService->getPaginatedActivities($pageSize, $page, $status, $address);
        if ($activity) {
            return ResponseHelper::jsonResponse(200, 'Show Activities ', $activity);
        }
        return ResponseHelper::jsonResponse(404, 'Not Found', null, 'Not Found');
    }

    public function store(Request $request)
    {
        $activityData = [
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'timeStart' => $request->input('timeStart'),
            'time_end' => $request->input('time_end'),
            'num_vol' => $request->input('num_vol'),
            'address' => $request->input('address'),
            'status' => $request->input('status'),
        ];
        $images = $request->file('images');
        $activity = $this->activityService->createActivity($activityData, $images);
        return ResponseHelper::jsonResponse(200, 'OK', $activity);
    }
    public function show($id) {
        $activity = $this->activityService->getOne($id);
        if ($activity) {
            return ResponseHelper::jsonResponse(200, 'OK', $activity);
        }
        return ResponseHelper::jsonResponse(404, 'Not Found', null, 'Not Found');
    }

    public function update(CreateActivityRequest $request, Activity $activity)
    {
        $updatedActivity = $this->activityService->updateActivity($activity, $request->all());
        return ResponseHelper::jsonResponse(200, 'Update Successfully', $activity);
    }
    public function delete(Activity $activity)
    {
        $activity = $this->activityService->deleteActivity($activity);
        if ($activity) {
            return ResponseHelper::jsonResponse(200, 'Delete Successfully', $activity);
        }
        return ResponseHelper::jsonResponse(404, 'Not Found', null, 'Not Found');
    }

}
