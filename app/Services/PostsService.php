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
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Pagination\LengthAwarePaginator;

class PostsService
{

    public function createPost(array $data, $thumbnailImage, $detailsImage)
    {
        $data['thumbnail_image'] = $this->uploadImage($thumbnailImage, 'thumbnails');
        $data['details_image'] = $this->uploadImage($detailsImage, 'details');
        $post = Post::create($data);
        return $post;
    }
    private function uploadImage($file, $folder)
    {
        $cloudinaryUpload = Cloudinary::upload($file->getRealPath(), [
            'folder' => $folder,
        ]);
        return $cloudinaryUpload->getSecurePath();
    }
    public function getAllPosts($page = 1, $pageSize = null, $status = null)
    {
        $query = Post::query();
        $pageSize = $pageSize ?? $query->count();
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


    public function updatePost($data)
    {
        $post = Post::findOrFail($data['id']);

        if ($post) {
            $result = $post->update($data -> all());
            return $result;
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
