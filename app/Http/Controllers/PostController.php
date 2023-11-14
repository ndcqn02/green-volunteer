<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PostsService;
use App\Helpers\ResponseHelper;



class PostController extends Controller
{
    protected $postsService;

    public function __construct(PostsService $postsService)
    {
        $this->postsService = $postsService;
    }

    public function index()
    {
        $posts = $this->postsService->getAllPosts();
        if ($posts) {
            return ResponseHelper::jsonResponse(200, 'All Posts Show', $posts);
        }
    }

    public function show($id)
    {
        $post = $this->postsService->getPostById($id);

        if ($post) {
            return ResponseHelper::jsonResponse(200, 'Post Show', $post);
        }
        return ResponseHelper::jsonResponse(404, 'Post Not Found', null, null);
    }


    public function create(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'user_id' => 'required',
            'status' => 'required|max:255',
            'images' => 'nullable|max:255',
        ]);

        $post = $this->postsService->createPost($data);
        return ResponseHelper::jsonResponse(200, 'New Post Show', $post);


    }
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'user_id' => 'required',
            'status' => 'required|max:255',
            'images' => 'nullable|max:255',
        ]);

        $result = $this->postsService->updatePost($id, $data);
        if ($result) {
            return ResponseHelper::jsonResponse(200, 'PostUpdate Succesfully', $result);
        }
        return ResponseHelper::jsonResponse(404, 'Post Not Found', null, null);
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


