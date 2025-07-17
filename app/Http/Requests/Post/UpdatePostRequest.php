<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // hoặc thêm kiểm tra quyền ở đây nếu muốn
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $this->post, // tránh trùng slug với bài khác
            'content' => 'required|string',
            'status' => 'nullable|in:draft,published',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ];
    }
}
