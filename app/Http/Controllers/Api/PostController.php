<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest as PostStorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest as PostUpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Services\Post\PostServiceInterface;
use Auth;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Lấy danh sách bài viết",
     *     tags={"Post"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Danh sách bài viết")
     * )
     */
    public function index(): JsonResponse
    {
        $posts = $this->postService->getAll();
        return response()->json(PostResource::collection($posts));
    }
/**
 * @OA\Post(
 *     path="/api/posts",
 *     summary="Tạo bài viết",
 *     tags={"Post"},
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 required={"title", "slug", "content", "category_id"},
 *                 @OA\Property(property="title", type="string", example="Tiêu đề"),
 *                 @OA\Property(property="slug", type="string", example="tieu-de"),
 *                 @OA\Property(property="content", type="string", example="Nội dung"),
 *                 @OA\Property(property="category_id", type="integer", example=1),
 *                 @OA\Property(property="image", type="file")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=201, description="Tạo thành công")
 * )
 */
  public function store(PostStorePostRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = $this->postService->store($data);
        return response()->json(new PostResource($post), 201);
    }
    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Xem chi tiết bài viết",
     *     tags={"Post"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID bài viết",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Chi tiết bài viết"),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function show($id): JsonResponse
    {
        $post = $this->postService->getById($id);
        return response()->json(new PostResource($post));
    }
/**
 * @OA\Put(
 *     path="/api/posts/{id}",
 *     summary="Cập nhật bài viết",
 *     tags={"Post"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID bài viết",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(property="title", type="string", example="Tiêu đề mới"),
 *                 @OA\Property(property="slug", type="string", example="tieu-de-moi"),
 *                 @OA\Property(property="content", type="string", example="Nội dung mới"),
 *                 @OA\Property(property="category_id", type="integer", example=2),
 *                 @OA\Property(property="image", type="file")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=200, description="Cập nhật thành công"),
 *     @OA\Response(response=404, description="Không tìm thấy")
 * )
 */
public function update(PostUpdatePostRequest $request, $id): JsonResponse
{
    $data = $request->validated();

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('posts', 'public');
    }

    $post = $this->postService->update($id, $data);
    return response()->json(new PostResource($post));
}

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     summary="Xóa bài viết",
     *     tags={"Post"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID bài viết cần xóa",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Xóa thành công"),
     *     @OA\Response(response=404, description="Không tìm thấy")
     * )
     */
    public function destroy($id): JsonResponse
    {
        $this->postService->destroy($id);
        return response()->json(['message' => 'Post deleted.'], 200);
    }
}
