<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $comment = new Comment;
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request->id;
        $comment->comment = $request->comment;

        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'comment added'
            // 'post' => $comment
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function comment(Request $request)
    {
        $comments = Comment::where('post_id', $request->id)->get();

        foreach ($comments as $comment) {
            # get user of post
            $comment->user;
           
        }

        return response()->json([
            'success'=>true,
            'comments' => $comments
        ]);
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
        $comment = Comment::find($request->id);

        // Verificando se ee o user que esta a editar seu comentario
        if (Auth::user()->id != $request->id) {
            # code...
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }
        $comment->comment = $request->comment;
        $comment->update();

        return response()->json([
            'success' => true,
            'message' => 'comment edited'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $comment = Comment::find($request->id);

        // Verificando se ee o user que esta a editar seu comentario
        if (Auth::user()->id != $comment->id) {
            # code...
            return response()->json([
                'success' => false,
                'message' => 'unauthorized access'
            ]);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'post deleted'
        ]);

    }
}
