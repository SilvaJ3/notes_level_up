<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Note;
use App\Models\NoteRoleUserPivot;
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
        $notes = Note::all()->sortByDesc("like");
        $user = User::find(Auth::user()->id);
        $userLike = Like::where("user_id", $user->id)->get();
        return view("pages.global.global", compact("notes", "userLike"));
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
        $store->content = $request->content;
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
        $show = Note::find($note)[0];
        $user = User::find(Auth::user()->id);
        $notes = $user->notes;
        $userLike = Like::where("user_id", $user->id)->get();
        return view("pages.perso.show", compact("show", "userLike"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        //
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
