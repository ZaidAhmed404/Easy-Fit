<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reviews extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class,'reviewerId');
    }
    public function paper(){
        return $this->belongsTo(paper::class,'paperId');
    }
    public function track(){
        return $this->belongsTo(tracks::class,'trackId');
    }
    
}
