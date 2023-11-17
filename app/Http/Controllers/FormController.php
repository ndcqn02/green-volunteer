<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\FormService;
use App\Http\Requests\FormsRequest;
use Illuminate\Http\JsonResponse;


class FormController extends Controller
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
        $posts = $this->formService->getAllforms($page, $pageSize, $filters);
        return ResponseHelper::jsonResponse(200, 'All Posts Show', $posts);

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


        $post = $this->formService->createform($request);
        return ResponseHelper::jsonResponse(200, 'New Form Show', $post);

    }
    public function update(FormsRequest $request, $formId)
    {


        $post = $this->formService->updateform($formId,$request);
        if ($post) {
            return ResponseHelper::jsonResponse(200, 'Form Update Succesfully', $post);
        }
        return ResponseHelper::jsonResponse(404, 'Post Not Found', null, null);

    }
    public function delete($id)
    {
        $result = $this->formService->softDeleteform($id);
        if ($result) {
            return ResponseHelper::jsonResponse(200,'Delete Form Succesfully', $result);
        }
        return ResponseHelper::jsonResponse(404,'Id Not Found', null,null);
    }
}
