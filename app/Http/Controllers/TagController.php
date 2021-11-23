<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Note;
use App\Models\NoteRoleUserPivot;
use App\Models\NoteTagPivot;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
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
        return view("pages.tags.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            "tag" => ["required", "max: 20"],
        ]);

        $tag = Tag::where("tag", $request->tag)->first();

        if ($tag) {
            return redirect()->back()->with("warning", "Tag déjà existant");;
        } else {
            if (Auth::user()->role_id == 2 && Auth::user()->credits >= 30) {
                $store = new Tag;
                $store->tag = $request->tag;
                $user = User::find(Auth::user()->id);
                $user->credits -= 30;

                $store->save();
                return redirect("/notes")->with("success", "Tag créé -- 30 🪙 dépensés");
            } elseif (Auth::user()->role_id == 1) {
                $store = new Tag;
                $store->tag = $request->tag;
    
                $store->save();
                return redirect("/notes")->with("success", "Tag créé");
            }
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {

        if (Auth::user()) {
            $show = Tag::find($tag->id);
            $tags = NoteTagPivot::where("tag_id", $show->id)->get();
            $filter = [];

            foreach ($tags as $tag) {
                $note = Note::where("id", $tag->note_id)->first();
                array_push($filter, $note);
            }
            
            $users = User::all();
            $pivot = NoteRoleUserPivot::all();

            $user = User::find(Auth::user()->id);
            $userLike = Like::where("user_id", $user->id)->get();
            return view("pages.tags.show", compact("show", "filter", "users", "pivot", "userLike"));
        } else {
            $show = Tag::find($tag->id);
            $tags = NoteTagPivot::where("tag_id", $show->id)->get();
            $filter = [];

            foreach ($tags as $tag) {
                $note = Note::where("id", $tag->note_id)->first();
                array_push($filter, $note);
            }

            $users = User::all();
            $pivot = NoteRoleUserPivot::all();

            return view("pages.tags.show", compact("show", "filter", "users", "pivot"));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        //
    }
}
