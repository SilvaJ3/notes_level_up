<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Models\Like;
use App\Models\Note;
use App\Models\NoteRoleUserPivot;
use App\Models\NoteTagPivot;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::user()) {
        $notes = Note::orderByDesc("like")->paginate(9);
        $users = User::all();
        $pivot = NoteRoleUserPivot::all();
        $tag_pivot = NoteTagPivot::all();
        $tags = Tag::all()->sortBy("tag");
        $user = User::find(Auth::user()->id);
        $userLike = Like::where("user_id", $user->id)->get();
        return view("pages.global.global", compact("notes", "userLike","users", "pivot", "tag_pivot", "tags"));
    } else {
        $notes = Note::orderByDesc("like")->paginate(9);
        $users = User::all();
        $pivot = NoteRoleUserPivot::all();
        $tag_pivot = NoteTagPivot::all();
        $tags = Tag::all()->sortBy("tag");
        return view("pages.global.global", compact("notes","users", "pivot", "tag_pivot", "tags"));
    }
})->middleware("onMobile");

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::resource('/notes', NoteController::class);

/* ---------------------------- Page : Vos notes ---------------------------- */

Route::get("/perso", function() {
    $user = User::find(Auth::user()->id);
    $notes = [];
    $pivot = NoteRoleUserPivot::where("user_id", $user->id)->where("role_notes_id", 1)->get();
    foreach ($pivot as $note_id) {
        $note = Note::where("id", $note_id->note_id)->first();
        array_push($notes, $note);
    }
    $userLike = Like::where("user_id", $user->id)->get();
    $users = User::all();
    return view("pages.perso.perso", compact("notes", "userLike", "pivot", "users"));
});

/* --------------------------- Page : Notes Likées -------------------------- */

Route::get("/liked", function() {
    $user = User::find(Auth::user()->id);
    $notes = $user->notes;
    $likeds = $user->like;
    $likeds_list = [];
    foreach ($likeds as $like) {
        array_push($likeds_list, $like);
    }
    $pivot = NoteRoleUserPivot::all();
    $users = User::all();
    $userLike = Like::where("user_id", $user->id)->get();
    return view("pages.liked.liked", compact("notes", "likeds_list", "pivot", "users", "userLike"));
})->middleware("onMobile");

/* ------------------------- Page : Notes Partagées ------------------------- */

Route::get("/shared", function() {
    $user = User::find(Auth::user()->id);
    $notes = $user->notes;
    $shared = NoteRoleUserPivot::where("role_notes_id", 2)->where("user_id", $user->id)->get();
    $shared_list = [];
    foreach ($shared as $shared) {
        $note = Note::find($shared->note_id);
        array_push($shared_list, $note);
    }
    $pivot = NoteRoleUserPivot::all();
    $users = User::all();
    $userLike = Like::where("user_id", $user->id)->get();

    return view("pages.shared.shared", compact("notes", "shared_list", "pivot", "users", "userLike"));
});

/* ------------------------------ Page : Profil ----------------------------- */

Route::resource('/user', UserController::class);

/* ---------------------------------- Tags ---------------------------------- */

Route::resource('/tags', TagController::class);

/* --------------------------- Fonctionnalité LIKE -------------------------- */

Route::post("/like/{id}/like", [LikeController::class, "like"]);
Route::delete("/like/{id}/unlike", [LikeController::class, "unlike"]);


/* -------------------------- Fonctionnalité Share -------------------------- */

Route::post("/note/{id}/share", [NoteController::class, "share"]);

/* ---------------------------------- Shop ---------------------------------- */

/* ------------------------------ Achat de like ----------------------------- */

Route::post("/shop/{id}/like", function($id) {

    $user = User::find($id);
    $user->credits -= 2;
    $user->likes += 1;

    $user->save();

    return redirect()->back()->with("success", "Achat validé -- + 1 ❤️");
});