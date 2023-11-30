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
        $page = $request->input('page');
        $pageSize = $request->input('pageSize');
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

        $thumbnailImage = $postRequest->file('thumbnail_image');
        $detailsImage = $postRequest->file('details_image');

        $postData = [
            'title' => $postRequest->input('title'),
            'body' => $postRequest->input('body'),
            'user_id' => $postRequest->input('user_id'),
            'status' => $postRequest->input('status'),
        ];
        $post = $this->postsService->createPost($postData, $thumbnailImage, $detailsImage);
        if ($post) {
            return ResponseHelper::jsonResponse(200, 'OK', $post);
        }
        return ResponseHelper::jsonResponse(400, 'Bad Request', null, 'Not Found');
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


