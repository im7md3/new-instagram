<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggleLike(Request $request){
        if(auth()->check()){
        $post=Post::find($request->post_id);
         $post->likeSystem(auth()->user());
        $likeCount=$post->likedByUsers()->count();
        $isLiked=$post->isLiked(auth()->user());
        return ['likeCount'=>$likeCount,'isLiked'=>$isLiked];
    }
}

}
