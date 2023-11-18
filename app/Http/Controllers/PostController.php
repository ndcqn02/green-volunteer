<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PostsService;
use App\Helpers\ResponseHelper;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use Illuminate\Http\JsonResponse;




class PostController extends Controller
{
    protected $postsService;

    public function __construct(PostsService $postsService)
    {
        $this->postsService = $postsService;
    }

    public function index(Request $request): JsonResponse
    {
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);
        $filters = $request->input('status');
        $posts = $this->postsService->getAllPosts($page, $pageSize, $filters);
        return ResponseHelper::jsonResponse(200, 'All Posts Show', $posts);

    }
    public function show($id)
    {
        $post = $this->postsService->getPostById($id);

        if ($post) {
            return ResponseHelper::jsonResponse(200, 'Post Show', $post);
        }
        return ResponseHelper::jsonResponse(404, 'Post Not Found', null, null);
    }


    public function create(PostRequest $postRequest)
    {
        $post = $this->postsService->createPost($postRequest);
        if ($post) {
            return ResponseHelper::jsonResponse(200, 'OK', $post);
        }
        return ResponseHelper::jsonResponse('Bad Request', $post, 400);


    }
    public function update(PostRequest $postRequest)
    {
        $checkExist = $this->postsService->getPostById($postRequest->id);

        if ($checkExist) {
            $activity = $this->postsService->updatePost($postRequest);
            return ResponseHelper::jsonResponse(200, 'OK', $activity);
        }
        return ResponseHelper::jsonResponse(400, 'Bad Request', null, 'Not Found');
    }

    public function delete($id)
    {
        $result = $this->postsService->softDeletePost($id);
        if ($result) {
            return ResponseHelper::jsonResponse(200,'Delete Data Succesfully', $result);
        }
        return ResponseHelper::jsonResponse(404,'Id Not Found', null,null);
    }
}


