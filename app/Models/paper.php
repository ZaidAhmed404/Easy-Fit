<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\tracks;
use App\Models\Authors;
use App\Models\reviewerPaper;
class paper extends Model
{
    use HasFactory;

    // public function uniqueTrack(){
    //     return $this->belongsTo(track::class,'track_id');
    // }
    public function track(){
        return $this->belongsTo(tracks::class,'trackId');
    }
    public function conference(){
        return $this->belongsTo(conference::class,'conferenceId');
    }
    public function authors(){
        return $this->hasMany(Authors::class,'paperId');
    }
    public function reviews(){
        return $this->hasMany(reviews::class,'paperId');
    }
    public function reviewers(){
        return $this->hasMany(reviews::class,'paperId');
    }
    public function reviewersCount(){
        return $this->hasMany(reviewerPaper::class,'PaperId')->count();
    }
    

    
}
