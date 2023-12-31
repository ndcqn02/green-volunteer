<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     *
     */

    public function rules(): array
    {
            return [
                'title' => 'required|max:255',
                'body' => 'required',
                'user_id' => 'required',
                'status' => 'required|max:255',
                'thumbnail_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'details_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
    }
}
