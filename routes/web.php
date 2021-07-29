<?php

use App\Models\User;
use App\Notifications\testNoti;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

use Inertia\Inertia;

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

Route::get('language/{language}', function ($language) {
    Session()->put('locale', $language);

    return redirect()->back();
})->name('language');

Route::get('/', function () {
        $profile = auth()->user();
        $posts = auth()->user()->home();
        $iFollow = $profile->iFollow()->take(3);
        $toFollow = $profile->otherUsers()->take(3);
        return Inertia::render('home', compact(['profile', 'iFollow', 'toFollow', 'posts']));

})->name('home')->middleware('auth');

Route::get('/explore',function(){
    $profile=auth()->user();
    $posts=$profile->explore();
    return Inertia::render('exploer',compact(['profile','posts']));
})->name('explore');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return redirect()->route('user.profile', auth()->user()->username);
})->name('dashboard');

Route::get('{user:username}', function ($username) {
    return User:: where('username', $username)->get();
    $profile = User::withCount(['followers' => function ($q) {
        return $q->where('accepted', true);
    }, 'follows' => function ($q) {
        return $q->where('accepted', true);
    }, 'posts'])->where('username', $username)->first();
    if($profile == null)
    {
        abort(404);
    }
    $posts = [];
    if ($profile->status == 'public' || Gate::allows('view-profile', $profile)) {
        $posts = $profile->posts;
    }
    $isFollowUser = false;
    if (auth()->check()) {
        $isFollowUser = auth()->user()->isFollow($profile);
    }
    if ($profile == null) {
        abort(404);
    }
    return Inertia::render('Profile', compact(['profile', 'posts', 'isFollowUser']));
})->name('user.profile');
Route::resource('/posts', App\Http\Controllers\PostController::class);
Route::resource('/comments', App\Http\Controllers\CommentController::class);
Route::post('/like', [App\Http\Controllers\LikeController::class, 'toggleLike'])->name('toggle.like');
Route::post('/follow', [App\Http\Controllers\FollowController::class, 'toggle'])->name('toggle.follow');
Route::get('{username}/followers', [App\Http\Controllers\FollowController::class, 'followers'])->name('show.followers');
Route::get('{username}/following', [App\Http\Controllers\FollowController::class, 'following'])->name('show.following');
Route::get('inbox', [App\Http\Controllers\FollowController::class, 'inbox'])->name('inbox');
Route::get('accept/{id}', [App\Http\Controllers\FollowController::class, 'changeAccept'])->name('accept');
Route::post('search', [App\Http\Controllers\PostController::class, 'search'])->name('search');
Route::get('test', [App\Http\Controllers\PostController::class, 'test']);



