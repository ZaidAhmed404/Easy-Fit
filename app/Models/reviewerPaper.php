<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\paper;
class reviewerPaper extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class,'reviewerId');
    }
    public function paper(){
        return $this->belongsTo(paper::class,'PaperId');
    }
    
}
