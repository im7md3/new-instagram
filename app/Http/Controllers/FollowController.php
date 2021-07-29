<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
class FollowController extends Controller
{
    public function toggle(Request $request){
        if(auth()->check()){
             $FollowingUser=User::find($request->user_id);
             auth()->user()->toggleFollow($FollowingUser);
             if($FollowingUser->status=='public'){
                 auth()->user()->setAccept($FollowingUser);
             }
            $isFollow=auth()->user()->isFollow($FollowingUser);
            return ['isFollow'=>$isFollow,'followerCount'=>$FollowingUser->followers()->where('accepted',true)->count(),'followingCount'=>$FollowingUser->follows()->count()];
        }
    }

    public function followers($username){
        $user=User::where('username',$username)->first();
        $followers=$user->followers()->where('accepted',true)->withCount(['followers as isFollow'=>function($q){
            $q->where('user_id',auth()->id());
        }])->withCasts(['isFollow'=>'boolean'])->get();
        return Inertia::render('followers',compact('followers'));
    }
    public function following($username){
        $user=User::where('username',$username)->first();
        $following=$user->follows()->where('accepted',true)->get();
        return Inertia::render('following',compact('following'));
    }

    public function inbox(){
        $profile=auth()->user();
        if($profile->followReq()==null){
            $requests=[];
        }else{
            $requests=$profile->followReq()->withCount(['followers as isFollow'=>function($q){
                $q->where('user_id',auth()->id());
            }])->withCasts(['isFollow'=>'boolean'])->get();
        }

        $pendings=$profile->pendingFollow();
        return Inertia::render('inbox',compact(['profile','requests','pendings']));
    }

    public function changeAccept($id){
        $user=User::find($id);
        DB::table('follows')->where('user_id',$id)->where('following_user_id',auth()->id())->update(['accepted'=>true]);
        return redirect()->back();
    }
}
