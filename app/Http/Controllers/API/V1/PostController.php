<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index() {
        return PostResource::collection(Post::all());
    }

    public function show(Post $post) {
        return new PostResource($post);
    }

    public function store(PostStoreRequest $request){
        $data = $request->validated();

        $user = Auth::user();

        $data['user_id'] = $user->id;

        $uniqueFileName = uniqid('post_', true) . '.html';

        $filePath = $request->file('file')->storeAs('posts', $uniqueFileName, 'public');

        $data['file_path'] = $filePath;

        $post = Post::create($data);

        return response()->json(new PostResource($post), 201);
    }


    public function like(Post $post){
        $user = Auth::user();

        if (!$post) {
            return response()->json(['error' => 'Пост не найден'], 404);
        }
        $user->likes()->syncWithoutDetaching($post->id);
        return response()->json(['message' => 'Лайк успешно поставлен'], 200);
    }

    public function publish(Post $post) {
        $user = Auth::user();
        if (!$post || $user->id !== $post->user_id) {
            return response()->json(['error' => 'Пост не найден'], 404);
        }

        $post->status = 'published';

        $post->save();

        return response()->json(['message' => 'Пост опубликован'], 200);
    }

    public function destroy(Post $post){
        if (!$post) {
            return response()->json(['error' => 'Пост не найден'], 404);
        }

        $post->destroy();

        return response()->json(['message' => 'Пост успешно удален'], 200);
    }

}
