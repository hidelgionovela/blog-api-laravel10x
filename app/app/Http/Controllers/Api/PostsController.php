<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->get();

        foreach ($posts as $post ) {
            # get user of post
            $post->user;
            // contando comentarios
            $post['commentsCount'] = count($post->comments);
            // contando likes
            $post['likesCount'] = count($post->likes);
            // verificando se o user gostou do seu proprio comentario
            $post['selfLike'] = false;
            foreach ($post->likes as $like) {
                if ($like->user_id == Auth::user()->id) {
                    $post['selfLike'] = true;
                }
            }
        }

        return response()->json([
            'success'=>true,
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = new Post;
        $post->user_id = Auth::user()->id;
        $post->description = $request->description;

        // Verificando se o campo photo foi preenchido ou nao
        if ($request->photo != '') {
            # code...
            $photo = time().'jpg';
            file_put_contents('storage/posts/'.$photo,base64_decode($request->photo));
            $post->photo = $photo;
        }

        $post->save();
        $post->user;
        return response()->json([
            'success' => true,
            'message' => 'posted',
            'post' => $post
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $post = Post::find($request->id);

        // Verificando se ee o user que esta a editar seu comentario
        if (Auth::user()->id != $request->id) {
            # code...
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }
        $post->description = $request->description;
        $post->update();
        return response()->json([
            'success' => true,
            'message' => 'post edited'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $post = Post::find($request->id);

        // Verificando se ee o user que esta a editar seu comentario
        if (Auth::user()->id != $request->id) {
            # code...
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }
       
        // Verificando se o post contem uma fotografia por deletar
        if($post->phote != ''){
            Storage::delete('public/posts/'.$post->photo);
        }

        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'post deleted'
        ]);
    }
}
