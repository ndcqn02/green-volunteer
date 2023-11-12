<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use App\Services\ActivityService;
use App\Http\Requests\Activity\CreateActivityRequest;

class ActivityController extends Controller
{
    protected $activityService;

    public function __construct()
    {
        $this->activityService = new ActivityService();
    }

    public function index()
    {
        $activity = $this->activityService->getAll();
        return ResponseHelper::jsonResponse(200, 'OK', $activity);
    }

    public function show($id)
    {
        $activity = $this->activityService->getOne($id);
        if ($activity) {
            return ResponseHelper::jsonResponse(200, 'OK', $activity);
        }
        return ResponseHelper::jsonResponse(404, 'Not Found', null, 'Not Found');
    }


    public function create(CreateActivityRequest $request)
    {
        $activity = $this->activityService->create($request);
        if ($activity) {
            return ResponseHelper::jsonResponse(200, 'OK', $activity);
        }
        return ResponseHelper::jsonResponse('Bad Request', $activity, 400);
    }


    public function update(CreateActivityRequest $request)
    {
        $checkExist = $this->activityService->getOne($request->id);

        if ($checkExist) {
            $activity = $this->activityService->update($request);
            return ResponseHelper::jsonResponse(200, 'OK', $activity);
        }
        return ResponseHelper::jsonResponse(400, 'Bad Request', null, 'Not Found');
    }

    public function delete($id)
    {
        $checkExist = $this->activityService->getOne($id);

        if ($checkExist) {
            $activity = $this->activityService->delete($id);
            return ResponseHelper::jsonResponse(200, 'OK', $activity);
        }
        return ResponseHelper::jsonResponse(404, 'Not Found', null, 'Not Found');
    }

}
