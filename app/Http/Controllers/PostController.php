<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required',
            'tags' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed. Please check the input fields.',
                'errors' => $validator->errors()
            ], 422);
        }

        $imagePath = null;
        $thumbnailPath = null;

        if ($request->hasFile('image')) {
            $paths = ImageHelper::uploadImage($request->file('image'));
            $imagePath = $paths['image'];
            $thumbnailPath = $paths['thumbnail'];
        }

        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'thumbnail' => $thumbnailPath,
            'status' => 'pending', // default
        ]);

        // Attach categories
        $post->categories()->attach($request->category_id);

        // Insert tags
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            foreach ($tags as $tagName) {
                $tag = new Tag(['name' => $tagName]);
                $post->tags()->save($tag);
            }
        }

        return response()->json([
            'status'=>'success',
            'message'=>'Post Add Successfully'
        ]);
    }
}
