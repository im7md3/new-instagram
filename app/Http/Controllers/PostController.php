<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;


class PostController extends Controller
{

    public function __construct(){
        $this->middleware('auth')->except(['show','test']);
    }

    public function index()
    {
        abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return Inertia::render('posts/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $image_path=imgPostUpload($request->image);
        $post=auth()->user()->posts()->create(['image'=>$image_path,'post_caption'=>$request->post_caption]);
        return redirect()->route('posts.show',$post)->with('success','تم اضافة المنشور بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if(auth()->check() || $post->user->status=="private"){
            $this->authorize('view',$post);
        }
        $isLikedPost=0;
        $isFollowUser=false;
        if(auth()->check()){
            $isLikedPost=$post->isLiked(auth()->user());
            $isFollowUser=auth()->user()->isFollow($post->user);
        }
        $post=$post::with(['user','comments'])->withCount('likedByUsers')->where('id',$post->id)->get();
        return Inertia::render('posts/show',compact(['post','isLikedPost','isFollowUser']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update',$post);
        return Inertia::render('posts/edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {

        $this->authorize('update',$post);
        $image_path=$post->image;
        if($request->image!=null){
            unlink($post->image);
            $image_path=imgPostUpload($request->image);
        }
        $post->update([
            'image'=>$image_path,
            'post_caption'=>$request->post_caption
        ]);
        return redirect()->route('posts.show',$post)->with('success','تم تعديل المنشور بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete',$post);
        $post=$post::find($post->id);
        unlink($post->image);
        $post->delete();
        return redirect()->route('user.profile',auth()->user()->username)->with('success','تم حذف المنشور بنجاح');
    }

    public function search(Request $request){
        if($request->key!=null || $request->key!=""){
            return $result=User::where('username','LIKE',"%$request->key%")->where('id','<>',auth()->id())->take(5)->get();
        }else{
            return ;
        }
    }

    public function test(Request $request){
        
        if($request->input('var')){
            return 'sss';
        }else{
            return 'aaa';
        }
    }
}
