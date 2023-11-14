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

class PostsService
{
    public function getAllPosts()
    {
    if(Post::all()->count() != 0)
    {
        return Post::all();
    }
    return false;
}

    public function getPostById($postId)
    {
        $Id = Post::find($postId);
        if($Id){
            return $Id;
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
