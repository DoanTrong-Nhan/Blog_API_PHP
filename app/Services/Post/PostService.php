<?php

namespace App\Services\Post;

use App\Repositories\Post\PostRepositoryInterface;

class PostService implements PostServiceInterface
{
    protected $postRepo;

    public function __construct(PostRepositoryInterface $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function getAll()
    {
        return $this->postRepo->getAll();
    }

    public function getById($id)
    {
        return $this->postRepo->findById($id);
    }

    public function store(array $data)
    {
        return $this->postRepo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->postRepo->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->postRepo->delete($id);
    }
}
