<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SubReviewer;
use App\Models\conference;
use App\Models\User;
use App\Models\tracks;
use App\Models\reviewerPaper;
use App\Models\reviewerConfiguration;
use App\Models\paper;
use App\Models\Authors;
use App\Models\reviews;
use DB;
use App\Models\conferenceReviewerConfiguration;
use Hashids\Hashids;

use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Database\Eloquent\Exception;
use Auth;
class SubReviewerController extends Controller
{
    //request dashboard
    public function requestBoardPage($subreviewerId){
        try{  
            $hashids = new Hashids('',40); 
            $subreviewerId=$hashids->decode($subreviewerId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $SubReviewer=SubReviewer::find($subreviewerId);
            $user = User::find(Auth::id());
            $track=tracks::where('id','=',$SubReviewer->trackId)->with('conference')->first();
            return view("SubReviewer/requestBoard")->with([
                'track' => $track,
                'user' => $user,
                'role' => $SubReviewer,
                'conference' => $track->conference
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //rejecting offer
    public function rejectOffer($id){
        try{  
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            SubReviewer::destroy($id);
            Alert::alert('Alert','Request Rejected');
            return redirect("/home");    
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //accepting offer
    public function acceptOffer($id){
        try{  
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $SubReviewer=SubReviewer::find($id);
            $SubReviewer->Status="ACCEPTED";
            $SubReviewer->save();
            Alert::alert('Alert','Request Accepted');
            return redirect("/home");
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //Displaying SubReviewer DashBoard
    public function dashBoard($trackId){
        try{  
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $user = User::find(Auth::id());
            $track=tracks::where('id','=',$trackId)->with('conference')->first();
            $papers=reviewerPaper::where('reviewerId',"=",Auth::id())->with('paper.authors.user')->get();
            $reviewconfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            return view("SubReviewer/Dashboard")->with([
                'reviewconfiguration' => $reviewconfiguration,
                'Papers' => $papers,
                'conference' => $track->conference,
                'track' => $track
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //showing assigned paper
    public function assignedpaper($id){
        try{  
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{ 
            $paper=paper::where('id','=',$id)->with('track')->first();
            $users=Authors::where('paperId',"=",$id)->with('user')->get();
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($paper->conferenceId);
            $reviews=reviews::where('paperId','=',$id)->get();
            return view("SubReviewer/assignedPaper")->with([
                "track"=>$paper->track,
                "users"=>$users,
                "Paper"=>$paper,
                "reviews"=>$reviews,
                "conferenceReviewerConfiguration"=>$conferenceReviewerConfiguration
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }
    

    //reviewing paper page
    public function reviewingPaperPage($id){
        try{  
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $paper=paper::where('id','=',$id)->with('track')->first();
            return view("SubReviewer/reviewPaperPage")->with([
                'track'=>$paper->track,
                "paperId"=>$id
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
        
    }

    //reviewing
    public function reviewingPaper(Request $request,$paperId){
        try{  
            $hashids = new Hashids('',40); 
            $paperId=$hashids->decode($paperId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $count=reviews::where('paperId',$paperId)->count();
            if($count>5){
                Alert::warning('Warning','Error Adding new Review.Review Limit Reached');
                return back();
            }
            $reviewer=reviewerPaper::where([
                ['paperId','=',$paperId],
                ['reviewerId','=',Auth::id()]
            ])->get()->first();
            $editingstatus=reviewerPaper::find($reviewer->id);
            $editingstatus->status="REVIEWED";
            $editingstatus->save();
            $paper=paper::find($paperId);
            $review=new reviews;
            $review->reviewerId=Auth::id();
            $review->paperId=$paperId;
            $review->trackId=$paper->trackId;
            $review->conferenceId=$paper->conferenceId;
            $review->evaluation=$request->get('evaluation');
            $review->confident=$request->get('confidence');
            $review->review=$request->get('comment');
            $review->paperReviewerId=$reviewer->id;
            $review->reviewForReviewers=$request->get('reviewForReviewers');
            $review->save();
            $id=$hashids->encode($paper->trackId);
            Alert::alert('Alert','Review Successfully Added');
            return redirect()->route('subReviewerDashboardBoard', ['id'=>$id]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function checkreviewsPage($trackId){
        try{  
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $track=tracks::find($trackId);
            $reviews = reviews::where('reviewerId', Auth::id())->with('paper')->get();
            $reviewconfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            return view("SubReviewer/checkReviews")->with([
                "track"=>$track,
                'reviewconfiguration' => $reviewconfiguration,
                "reviews"=>$reviews
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    
    //editing review page
    public function editreviewPage($reviewId){
        try{  
            $hashids = new Hashids('',40); 
            $reviewId=$hashids->decode($reviewId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $review = reviews::where('id','=',$reviewId)->with('track')->first();
            return view("SubReviewer/editReview")->with([
                'track'=>$review->track,
                "Review"=>$review
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //editing review
    public function editreview(Request $request,$reviewId){
        try{  
            $hashids = new Hashids('',40); 
            $reviewId=$hashids->decode($reviewId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $review = reviews::find($reviewId);   
            $review->evaluation=$request->get('evaluation');
            $review->confident=$request->get('confidence');
            $review->review=$request->get('comment');
            $review->reviewForReviewers=$request->get('reviewForReviewers');
            $review->save();
            $id=$hashids->encode($review->trackId);
            Alert::alert('Alert','Review Successfully Edited');
            return redirect()->route('subReviewerDashboardBoard', ['id'=>$id]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function showingAllSubmissions($trackId){
        try{  
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $track=tracks::find($trackId);
            $papers=reviewerPaper::where('reviewerId',"=",Auth::id())->with('paper.authors.user')->get();
            $reviewconfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            return view('SubReviewer/showingAllSubmissions')->with([
                'track'=>$track,
                'reviewconfiguration' => $reviewconfiguration,
                'Papers' => $papers
                ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }
    
    
    public function conferenceData($trackId){
        try{
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0];
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $track=tracks::where('id',$trackId)->with('conference')->first();

            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            // $papers=reviewerPaper::where('reviewerId',"=",Auth::id())->with('paper.track','paper.authors.user')->get();            
            return view('conference/subreviewerConferenceData')->with([
                'track'=>$track,
                'conferenceReviewerConfiguration'=>$conferenceReviewerConfiguration
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

}
