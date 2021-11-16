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
use Illuminate\Support\Facades\DB;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::orderByDesc("like")->paginate(10);
        $user = User::find(Auth::user()->id);
        $users = User::all();
        $pivot = NoteRoleUserPivot::all();
        $userLike = Like::where("user_id", $user->id)->get();
        $tag_pivot = NoteTagPivot::all();
        $tags = Tag::all()->sortBy("tag");
        return view("pages.global.global", compact("notes", "userLike","users", "pivot", "tag_pivot", "tags"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();
        return view("pages.perso.newNote", compact("tags"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store = new Note;
        $store->title = $request->title;
        $store->content = $request->summary_ckeditor;
        $store->like = 0;
        $store->save();

        // On récupère les tags de notre formulaire
        $tag1 = $request->tag1;
        $tag2 = $request->tag2;
        $tag3 = $request->tag3;

        // On met sous forme de tableau nos tags et ensuite, on filtre notre array pour avoir uniquement les valeurs uniques
        $tags = [];
        array_push($tags, $tag1, $tag2, $tag3);
        $unique = array_unique($tags);
        
        if (in_array("none", $unique)) {
            $index = array_search("none", $unique);
            array_splice($unique, $index);
        }

        // On insert dans notre table
        foreach ($unique as $tag) {
            DB::table('note_tag_pivots')->insert([
                [
                    "note_id" => $store->id,
                    "tag_id" => $tag,
                ]
            ]);
        }

        // Table pivot
        $user = Auth::user();
        
        DB::table("note_role_user_pivots")->insert([
            [
                "note_id" => $store->id,
                "role_notes_id" => 1, // Par défaut 1 car on crée la note
                "user_id" => $user->id,
            ]
        ]);


        return redirect("/perso");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        $show = Note::find($note->id);
        $user = User::find(Auth::user()->id);
        $notes = $user->notes;
        $userLike = Like::where("user_id", $user->id)->get();
        $pivot_author = NoteRoleUserPivot::where("note_id", $show->id)->where("role_notes_id", 1)->first();
        $author = User::find($pivot_author->user_id);
        $editor = NoteRoleUserPivot::where("note_id", $show->id)->where("role_notes_id", 2)->where("user_id", $user->id)->first();

        if($editor) {
            $editor = True;
        } else {
            $editor = False;
        }
                
        return view("pages.perso.show", compact("show", "userLike", "author", "editor"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        $edit = Note::find($note->id);
        $tags = Tag::all();
        return view("pages.perso.edit", compact("edit", "tags"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        $update = Note::find($note->id);
        $note = Note::find($note->id);
        $update->title = $request->title;
        $update->content = $request->summary_ckeditor;
        $update->like = $note->like;
        $update->save();

        // On récupère les tags de notre formulaire
        $tag1 = $request->tag1;
        $tag2 = $request->tag2;
        $tag3 = $request->tag3;

        // On met sous forme de tableau nos tags et ensuite, on filtre notre array pour avoir uniquement les valeurs uniques
        $tags = [];
        array_push($tags, $tag1, $tag2, $tag3);
        $unique = array_unique($tags);

        $oldTags = NoteTagPivot::where("note_id", $update->id)->get();

        foreach ($oldTags as $tag) {
            $tag->delete();
        }
        
        // On insert dans notre table
        foreach ($unique as $tag) {
            DB::table('note_tag_pivots')->insert([
                [
                    "note_id" => $update->id,
                    "tag_id" => $tag,
                ]
            ]);
        }

        return redirect("/notes/".$update->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $destroy = Note::find($note->id);

        // On supprime toutes les liaisons auteur et éditeur sur cette note
        $note_roles = NoteRoleUserPivot::where("note_id", $destroy->id)->get();
        foreach ($note_roles as $note_role) {
            $note_role->delete();
        }

        // On supprime toutes les liaisons tags avec cette note
        $tags = NoteTagPivot::where("note_id", $destroy->id)->get();
        foreach ($tags as $tag) {
            $tag->delete();
        }
        
        // On incrémente le contingent de like des utilisateurs ayant liké ce post
        $likes = Like::where("note_id", $destroy->id)->get();
        foreach ($likes as $like) {
            $user = User::find($like->user_id);
            $user->likes += 1;
            $user->save();
            $like->delete();
        }

        $destroy->delete();
        return redirect()->back();
    }

    public function share(Request $request, $id)
    {
        $note = Note::find($id);
        $user = Auth::user();
        $email = $request->email;
        $sharedWith = User::where("email", $email)->first();

        if ($sharedWith) { // On vérifie si l'email existe déjà dans la base de données
            $alreadyEditor = NoteRoleUserPivot::where("note_id", $note->id)->where("role_notes_id", 2)->where("user_id", $sharedWith->id)->first();
    
            if ($alreadyEditor) {
                return redirect()->back();
            } else {
                DB::table("note_role_user_pivots")->insert([
                    [
                        "note_id" => $note->id,
                        "role_notes_id" => 2, // Par défaut 2 car on partage la note
                        "user_id" => $sharedWith->id,
                    ]
                ]);
            }
        } else {
            return redirect()->back();
        }
        
        return redirect()->back();
        
    }
}
