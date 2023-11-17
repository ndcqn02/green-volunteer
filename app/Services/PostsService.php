<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseHelper;
use Illuminate\Database\Eloquent\SoftDeletes;
use LDAP\Result;
use Illuminate\Pagination\LengthAwarePaginator;

class PostsService
{


    public function getAllPosts($page = 1, $pageSize = 10, $status = null)
    {
        $query = Post::query();

        if ($status !== null) {
            $query->where('status', $status);
        }

        return $query->paginate($pageSize, ['*'], 'page', $page);

    }
    public function getPostById($postId)
    {
        $post = Post::find($postId);
        if($post){
            return $post;
        }
        return false;
    }

    public function createPost($data)
    {
        return Post::create($data);
    }

    public function updatePost($postId, $data)
    {
        $post = Post::find($postId);

        if ($post) {
            return $post->update($data);;
        }
        return false;
    }

    public function softDeletePost($postId)
    {
        $post = Post::find($postId);

        if ($post) {
            $result = Post::destroy($postId);
            return $result;
        }
        return false;
    }

}
