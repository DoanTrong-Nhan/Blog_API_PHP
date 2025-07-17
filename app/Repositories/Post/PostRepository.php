<?php

namespace App\Repositories\Post;

use App\Models\Post;

// app/Repositories/PostRepository.php
class PostRepository implements PostRepositoryInterface
{
    public function getAll()
    {
        return Post::with('user', 'category')->latest()->paginate(10);
    }

    public function findById($id)
    {
        return Post::findOrFail($id);
    }

    public function create(array $data)
    {
        return Post::create($data);
    }

    public function update($id, array $data)
    {
        $post = $this->findById($id);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = $this->findById($id);
        $post->delete();
    }
}
