<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContestController extends Controller
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
     * @param  \App\Models\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function show(Contest $contest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function edit(Contest $contest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contest $contest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contest $contest)
    {
        //
    }

    public function vote(Request $request, $id)
    {
        $user = User::find(Auth::user()->id);
        if ($user->vote == 0) {
            return redirect()->back()->with("Vous avez déjà voté ⛔");
        } else {
            $user->vote -= 1; // On décrémente le nombre de votes
            $user->credits += 2; // Le vote permet d'obtenir 2 crédits
            $user->save();

            $note = Note::find($id);

            $contest = new Contest;
            $contest->note_id = $note->id;
            $contest->user_id = $user->id;
            $contest->save();
            return redirect()->back()->with("Success", "Votre vote a bien été pris en compte 🥰");
        }
        
    }
}
