<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostUserLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index() {
        $posts = Post::all();
        return response()->json($posts, 200);
    }

    public function show($post_id) {
        $post = Post::findOrFail($post_id);
        return response()->json($post, 200);
    }

    public function create(Request $request){
        $data = $request->validate([
            'title' => 'required|string|min:4',
            'description' => 'required|string',
            'file' => 'required|file',
        ]);

        $user = Auth::user();

        $data['user_id'] = $user->id;

        $uniqueFileName = uniqid('post_', true) . '.html';

        $filePath = $request->file('file')->storeAs('posts', $uniqueFileName, 'public');

        $data['file_path'] = $filePath;

        $post = Post::create($data);

        return response()->json($post, 201);
    }


    public function like($post_id){
        $user = Auth::user();

        $post = Post::findOrFail($post_id);

        if (!$post) {
            return response()->json(['error' => 'Пост не найден'], 404);
        }

        $user->likes()->syncWithoutDetaching([$post_id]);
        return response()->json(['message' => 'Лайк успешно поставлен'], 200);
    }

    public function publish($post_id) {
        $user = Auth::user();
        $post = Post::findOrFail($post_id);
        if (!$post || $user->id !== $post->user_id) {
            return response()->json(['error' => 'Пост не найден'], 404);
        }

        $post->status = 'published';

        $post->save();

        return response()->json(['message' => 'Пост опубликован'], 200);
    }

}
