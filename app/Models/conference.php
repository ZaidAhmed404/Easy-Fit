<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tracks;
use App\Models\User;
class conference extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class,'userId');
    }
    public function tracks(){
        return $this->hasMany(tracks::class,'conferenceId');
    }
    public function superchairs(){
        return $this->hasMany(Superchair::class,'conferenceId');
    }
    public function trackchairs(){
        return $this->hasMany(Trackchair::class,'conferenceId');
    }
    public function papers(){
        return $this->hasMany(paper::class,'conferenceId');
    }
    public function reviewer(){
        return $this->hasMany(Reviewer::class,'conferenceId');
    }
    
    public function reviews(){
        return $this->hasMany(reviews::class,'conferenceId');
    }
}
