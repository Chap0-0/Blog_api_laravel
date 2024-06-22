<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::all();
        return response()->json($posts, 200);
    }

    public function show($id) {
        $post = Post::findOrFail($id);
        return response()->json($post, 200);
    }

    public function create(Request $request){
        $data = $request->validate([
            'title' => 'required|string|min:4',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'file' => 'required|file',
        ]);

        $uniqueFileName = uniqid('post_', true) . '.html';

        $filePath = $request->file('file')->storeAs('posts', $uniqueFileName, 'public');

        $data['file_path'] = $filePath;

        $post = Post::create($data);

        return response()->json($post, 201);
    }
}
