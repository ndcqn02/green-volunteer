<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\FormService;
use App\Http\Requests\FormsRequest;
use Illuminate\Http\JsonResponse;


class FormsController extends Controller
{
    protected $formService;
    public function __construct(FormService $formService){
        $this->formService = $formService;
    }
    public function index(Request $request): JsonResponse
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);
        $filters = $request->input('status');
        $forms = $this->formService->getAllforms($page, $pageSize, $filters);
        return ResponseHelper::jsonResponse(200, 'All Forms Show', $forms);

    }
    public function show($Id)
    {
        $form = $this->formService->getformById($Id);
        if ($form) {
            return ResponseHelper::jsonResponse(200, 'Form index ID Show', $form);
        }
        return ResponseHelper::jsonResponse(200, 'Data Not Found', $form);

    }
    public function create(FormsRequest $request)
    {
        $form = $this->formService->createForm($request);
        if ($form) {
            return ResponseHelper::jsonResponse(200, 'New Form Create Succesfully', $form);
        }
        return ResponseHelper::jsonResponse('Bad Request', $form, 400);

    }
    public function update(FormsRequest $formRequest)
    {
        $checkExist = $this->formService->getformById($formRequest->id);

        if ($checkExist) {
            $activity = $this->formService->updateForm($formRequest);
            return ResponseHelper::jsonResponse(200, 'New Form Update Succesfully', $activity);
        }
        return ResponseHelper::jsonResponse(400, 'Bad Request', null, 'Not Found');

    }
    public function delete($id)
    {
        $result = $this->formService->softDeleteForm($id);
        if ($result) {
            return ResponseHelper::jsonResponse(200,'Delete Form Succesfully', $result);
        }
        return ResponseHelper::jsonResponse(404,'Id Not Found', null,null);
    }
}
