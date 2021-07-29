<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','post_caption','image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->with('user');
    }

    public function  likedByUsers(){
        return $this->belongsToMany(User::class,'likes');
    }

    public function  isLiked(User $user){
        return $this->likedByUsers()->wherePivot('user_id',$user->id)->wherePivot('post_id',$this->id)->exists();
    }

    public function  like(User $user){
        return $this->likedByUsers()->save($user);
    }

    public function  dislike(User $user){
        return $this->likedByUsers()->detach($user);
    }

    public function likeSystem(User $user){
        if($this->isLiked($user)){
            $this->dislike($user);
        }else{
            $this->like($user);
        }
    }

    public function getCreatedAtAttribute($value)
    {
        /* return date("d F Y H:i", strtotime($value)); */
        $value = new Carbon($value);  
        return $value->diffForHumans();                     
    }
}
