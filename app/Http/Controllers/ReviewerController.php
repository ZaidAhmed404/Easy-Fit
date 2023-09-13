<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\easyfitrole;
use App\Models\Reviewer;
use App\Models\tracks;
use App\Models\User;
use App\Models\conference;
use App\Models\paper;
use Auth;
use App\Models\conferenceReviewerConfiguration;
use App\Models\reviewerPaper;
use App\Models\SubReviewer;
use App\Models\Authors;
use App\Models\reviews;
use Illuminate\Database\Eloquent\Exception;
use RealRashid\SweetAlert\Facades\Alert;
use Hashids\Hashids;
use DB;
use Mail;
use App\Models\reviewerConfiguration;

class ReviewerController extends Controller
{
    
    //request dashboard
    public function requestBoardPage($reviewerId){
        try{  
            $hashids = new Hashids('',40); 
            $reviewerId=$hashids->decode($reviewerId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $Reviewer=Reviewer::find($reviewerId);
            $user = User::find(Auth::id());
            $track=tracks::where('id','=',$Reviewer->trackId)->with('conference')->first();
            return view("Reviewer/requestDashboard")->with([
                'track' => $track,
                'conference' => $track->conference,
                'role' => $Reviewer,
                'user' => $user
            ]);    
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //Displaying Reviewer DashBoard
    public function dashBoard($trackId){
        try{  
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $track=tracks::where('id','=',$trackId)->with('conference')->first();
            $papers=reviewerPaper::where('reviewerId',"=",Auth::id())->with('paper','paper.authors.user')->get();
            $reviewconfiguration=conferenceReviewerConfiguration::find($track->conference->id);
            return view("Reviewer/Dashboard")->with([
                'track' => $track,
                'reviewconfiguration' => $reviewconfiguration,
                'Papers' => $papers,
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
            Reviewer::destroy($id);
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
            $Reviewer=Reviewer::find($id);
            $Reviewer->Status="ACCEPTED";
            $Reviewer->save();
            Alert::success('Success','Request Accepted');
            return redirect("/home");
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
            $paper=paper::where('id',$id)->with('conference')->first();
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($paper->conference->id);
            $track=tracks::find($paper->trackId);
            $users=Authors::where('paperId',"=",$id)->with('user')->get();
            $reviews=reviews::where('paperId',"=",$id)->get();
            return view("Reviewer/assignedPaper")->with([
                "track"=>$track,
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
    public function reviewingPaperPage($paperId){
        try{  
            $hashids = new Hashids('',40); 
            $paperId=$hashids->decode($paperId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $paper=paper::find($paperId);
            $track=tracks::find($paper->trackId);
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($paper->conferenceId);
            return view("Reviewer/reviewingPaper")->with([
                "paperId"=>$paperId,
                'track'=>$track,
                'conferenceReviewerConfiguration'=>$conferenceReviewerConfiguration
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
            Alert::success('Success','Review Successfully Added');
            return redirect()->route('ReviewerDashboard', ['id'=>$id]);
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
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            $reviews = reviews::
            where('reviewerId', Auth::id())->with('paper')->get();
            return view("Reviewer/checkReviews")->with([
                "track"=>$track,
                "reviews"=>$reviews,
                'conferenceReviewerConfiguration' => $conferenceReviewerConfiguration
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
            $review = reviews::find($reviewId);
            $track = tracks::find($review->trackId);  
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($review->conferenceId);   
            return view("Reviewer/editReview")->with([
                "track"=>$track,
                "Review"=>$review,
                'conferenceReviewerConfiguration'=>$conferenceReviewerConfiguration
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
            Alert::success('Success','Review Successfully Edited');
            return redirect()->route('ReviewerDashboard', ['id'=>$id]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    
    //deleting review
    public function deletereview($reviewId){
        try{  
            $hashids = new Hashids('',40); 
            $reviewId=$hashids->decode($reviewId)[0];
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $review=reviews::find($reviewId);
            $reviewer=reviewerPaper::where([
                ['PaperId','=',$review->paperId],
                ['reviewerId','=',Auth::id()]
            ])->get()->first();
            $editingstatus=reviewerPaper::find($reviewer->id);
            $editingstatus->status="NOT REVIEWED";
            $editingstatus->save();
            reviews::destroy($reviewId);
            Alert::alert('Alert','Review Successfully Deleted');
            return back();    
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    
    //creating subreviewer
    public function createSubReviewer($trackId){
        try{  
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $track=tracks::find($trackId);
            return view('SubReviewer/create')->with([
                "track"=>$track
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    
    //showing subreviewer
    public function showSubReviewer(Request $request,$trackId){
        try{  
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $email=$request->get('email');
            $user = User::where('email',$email)->first();
            $track=tracks::find($trackId);
            if($user==null){    
                Alert::error('Error','User not REGISTERED on easyFit');
                return back();
            }    
            return view('SubReviewer/showData')->with([
                'track' => $track,
                'user' => $user
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    
    //requesting  subreviewer
    public function requestSubReviewer(Request $request,$trackId){
        try{  
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $email=$request->get('email');
            $user = User::where('email',$email)->first();
            $track=tracks::where('id','=',$trackId)->with('conference')->first();
            $Subreviewer=new SubReviewer;   
            $Subreviewer->userId=$user->id;
            $Subreviewer->conferenceId=$track->conference->id;
            $Subreviewer->Status="REQUESTED";
            $Subreviewer->RequestedBy=Auth::id();
            $Subreviewer->trackId=$trackId;
            $Subreviewer->save();
            $data = array ('firstName'=>$user->firstName,'lastName'=>$user->lastName,'FirstName'=>Auth::user()->firstName,'LastName'=>Auth::user()->lastName,'email'=>Auth::user()->email,'track'=>$track->Name,'conference'=>$track->conference->conferenceName);
            Mail :: send (  'Mails.TrackChair.RequestingReviewer' , $data , function ( $message ) use ($email){
                $message -> to ( $email ,"SubReviewer" )-> subject
                ( 'Regarding Requesting as SubReviewer' );
                $message -> from ( 'xyz@gmail.com' , 'EasyFit Management Team');
            });  
            $trackId=$hashids->encode($trackId); 
            Alert::success('Success','Request Successfully Send to Subreviewer');
            return redirect()->route('ReviewerDashboard', ['id'=>$trackId]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    
    //showing all subreviewer
    public function allSubReviewer($trackId){
        try{  
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
            $track=tracks::find($trackId);
            $users=SubReviewer::where('RequestedBy',"=",Auth::id())->with('user')->get();
            
            $reviewconfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            return view('Reviewer/allSubreviewers')->with([
                'track' => $track,
                'users' => $users,
                'reviewconfiguration' => $reviewconfiguration
            ]);
        
    }
    

    //showing assigned papers
    public function showingassignedPaper($userId){
        try{  
            $hashids = new Hashids('',40); 
            $userId=$hashids->decode($userId)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $papers=reviewerPaper::where('reviewerId',"=",Auth::id())->with('paper')->get();
            return view('Reviewer/assignPaper')->with([
                'papers' => $papers,
                'userId' => $userId
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    
    //assigning paper
    public function assigningPaper(Request $request,$userId){
        try{  
            $hashids = new Hashids('',40); 
            $userId=$hashids->decode($userId)[0];       
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $paper=paper::find($request->get("paper"));
            $track=tracks::where('id','=',$paper->trackId)->with('conference')->first();
            $reviewerPaper=new reviewerPaper;
            $reviewerPaper->PaperId=$paper->id;
            $reviewerPaper->reviewerId=$userId;
            $reviewerPaper->status="NOT REVIEWED";
            $reviewerPaper->trackId=$track->id;
            $reviewerPaper->conferenceId=$track->conference->id;
            $reviewerPaper->save();
            $id=$hashids->encode($paper->trackId);
            Alert::success('Success','Paper successfully Assigned to SubReviewer');
            return redirect()->route('ReviewerDashboard', ['id'=>$id]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function showingAllAssignedPapers($trackId){
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
            return view('Reviewer/allAssignedPapers')->with([
                'track'=>$track,
                'reviewconfiguration' => $reviewconfiguration,
                'Papers' => $papers
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function statusSubmissions($trackId){
        try{
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0];
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $track=tracks::find($trackId);
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            $papers=reviewerPaper::where('reviewerId',"=",Auth::id())->with('paper.track','paper.authors.user')->get();            
            return view('Reviewer/statusSubmissions')->with([
                'conferenceReviewerConfiguration' => $conferenceReviewerConfiguration,
                'track'=>$track,
                "Papers"=>$papers
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
            return view('conference/reviewerConferenceData')->with([
                'track'=>$track,
                'conferenceReviewerConfiguration'=>$conferenceReviewerConfiguration
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }
}
