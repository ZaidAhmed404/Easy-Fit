<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\conference;

class tracks extends Model
{
    use HasFactory;
    
    
    public function conference(){
        return $this->belongsTo(conference::class,'conferenceId');
    }
    public function trackchairs(){
        return $this->hasMany(Trackchair::class,'trackId');
    }
    public function papers(){
        return $this->hasMany(paper::class,'trackId');
    }
    public function reviewer(){
        return $this->hasMany(Reviewer::class,'trackId');
    }
    public function reviews(){
        return $this->hasMany(reviews::class,'trackId');
    }
}
