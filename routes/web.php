<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\NoteController;
use App\Models\Like;
use App\Models\Note;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::resource('/notes', NoteController::class);

/* ---------------------------- Page : Vos notes ---------------------------- */

Route::get("/perso", function() {
    $user = User::find(Auth::user()->id);
    $notes = $user->notes;
    $userLike = Like::where("user_id", $user->id)->get();
    return view("pages.perso.perso", compact("notes", "userLike"));
});


/* --------------------------- Functionnalité LIKE -------------------------- */

Route::post("/like/{id}/like", [LikeController::class, "like"]);
Route::delete("/like/{id}/unlike", [LikeController::class, "unlike"]);
