<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $items = Post::orderBy('id', 'desc')->paginate(10);
        return view('admin.posts.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts',
            'category_id' => 'required:exists:categories, id',
        ]);

        $data['user_id'] = auth('web')->id();

        $post = Post::create($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Éxito',
            'text' => 'El post se ha creado correctamente'
        ]);

        return redirect()->route('admin.posts.edit', $post->id);
    }

    public function show(Post $post)
    {
        //
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            // Excluye el slug de este registro
            'slug' => 'required|string|max:255|unique:posts,slug,' . $post->id,
            'category_id' => 'required:exists:categories, id',
            'excerpt' => 'nullable',
            'content' => 'nullable',
            'image' => 'nullable|image',
            'is_published' => 'required|boolean',
        ]);

        if ($request->hasFile('image')){
            if ($post->image_path){
               Storage::delete($post->image_path); 
            }
            // $data['image_path'] = Storage::put('posts', $request->image);
            $data['image_path'] = $request->image->store('posts', 'public');
        }
        
        $post->update($data);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Éxito',
            'text' => 'El post se ha actualizado correctamente'
        ]);

        return redirect()->route('admin.posts.edit', $post);
    }

    public function destroy(Post $post)
    {
        //
    }
}
