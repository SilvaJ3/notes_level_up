<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Like $like)
    {
        //
    }

    public function like(Request $request, $id)
    {
        $user = User::find(Auth::user()->id);
        $note = Note::find($id);
        $like = new Like;
        $like->note_id = $id;
        $like->user_id = $user->id;
        $user->likes -= 1;
        $note->like += 1;

        $user->save();
        $note->save();
        $like->save();

        return redirect()->back();
    }

    public function unlike(Request $request, $id)
    {
        $user = User::find(Auth::user()->id);
        $note = Note::find($id);
        $like = Like::where("note_id", $note->id)->where("user_id", $user->id)->get();
        $user->likes += 1; // On incrémente le nombre de like possible pour l'user
        $note->like -= 1; // On décrémente le nombre de like

        $user->save();
        $note->save();
        $like[0]->delete();

        return redirect()->back();
    }


}
