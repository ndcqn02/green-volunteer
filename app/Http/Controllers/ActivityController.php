<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use App\Services\ActivityService;
use App\Http\Requests\Activity\CreateActivityRequest;
use Illuminate\Http\JsonResponse;


class ActivityController extends Controller
{
    protected $activityService;

    public function __construct()
    {
        $this->activityService = new ActivityService();
    }
    public function index(Request $request): JsonResponse
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);
        $filters = $request->input('status');
        $posts = $this->activityService->getAll($page, $pageSize, $filters);
        return ResponseHelper::jsonResponse(200, 'All Posts Show', $posts);

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
