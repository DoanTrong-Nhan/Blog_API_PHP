<?php

namespace App\Http\Controllers\Api;
// app/Http/Controllers/Api/PostController.php

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest as PostStorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest as PostUpdatePostRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Services\Post\PostServiceInterface;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    public function index(): JsonResponse
    {
        $posts = $this->postService->getAll();
        return response()->json(PostResource::collection($posts));
    }

    public function store(PostStorePostRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = $this->postService->store($data);
        return response()->json(new PostResource($post), 201);
    }

    public function show($id): JsonResponse
    {
        $post = $this->postService->getById($id);
        return response()->json(new PostResource($post));
    }

    public function update(PostUpdatePostRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = $this->postService->update($id, $data);
        return response()->json(new PostResource($post));
    }

    public function destroy($id): JsonResponse
    {
        $this->postService->destroy($id);
        return response()->json(['message' => 'Post deleted.'], 200);
    }
}
