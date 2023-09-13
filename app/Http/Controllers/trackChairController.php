<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\trackchair;
use Auth;
use App\Models\tracks;
use App\Models\conference;
use App\Models\paper;
use App\Models\Reviewer;
use App\Models\SubReviewer;
use App\Models\User;
use App\Models\reviewerPaper;
use App\Models\Authors;
use App\Models\conferenceReviewerConfiguration;
use DB;
use Mail;
use App\Models\reviews;
use App\Models\reviewerConfiguration;

use RealRashid\SweetAlert\Facades\Alert;
use Hashids\Hashids;

use Illuminate\Database\Eloquent\Exception;
class trackChairController extends Controller
{
    
    
    //Displaying TrackChair DashBoard
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
            $papers=paper::where("trackId",'=',$trackId)->with('authors.user')->get();
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            return view("TrackChair/Dashboard")->with([
                'Track' => $track,
                'conference' => $track->conference,
                'papers' => $papers,
                'conferenceReviewerConfiguration'=>$conferenceReviewerConfiguration
                ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //adding Reviewer Page
    public function addingReviewer($trackId){
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
            return view("TrackChair/addingReviewer")->with([
                'Track' => $track,
                'conferenceReviewerConfiguration'=>$conferenceReviewerConfiguration
            ]);     
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //displaying reviewer data
    public function showingReviewerData(Request $request,$trackId){
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
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            return view('Reviewer/showingReviewerData')->with([
                'Track' => $track,
                'user' => $user,
                'conferenceReviewerConfiguration'=>$conferenceReviewerConfiguration
                ]);    
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //Sending Request to Reviewer
    public function sendRequest(Request $request,$trackId){
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
            $Reviewer=new Reviewer;   
            $Reviewer->userId=$user->id;
            $Reviewer->conferenceId=$track->conference->id;
            $Reviewer->Status="REQUESTED";
            $Reviewer->trackId=$trackId;
            $Reviewer->save();        
            $data = array ('firstName'=>$user->firstName,'lastName'=>$user->lastName,'FirstName'=>Auth::user()->firstName,'LastName'=>Auth::user()->lastName,'email'=>Auth::user()->email,'track'=>$track->Name,'conference'=>$track->conference->conferenceName);
            Mail :: send (  'Mails.TrackChair.RequestingReviewer' , $data , function ( $message ) use ($email){
                $message -> to ( $email ,"Reviewer" )-> subject
                ( 'Regarding Requesting as Reviewer' );
                $message -> from ( 'xyz@gmail.com' , 'EasyFit Management Team');
            });   
            $trackId=$hashids->encode($trackId); 
            Alert::success('Success','Request successfully Sent to Reviewer');
            return redirect()->route('TrackChairDashboard', ['id'=>$trackId]);
        }
        catch(\Exception $e){
            abort(404);
        }    
    }

    //displaying all reviewers
    public function displayReviewers($trackId){
        
        try{ 
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{ 
            $track=tracks::find($trackId);
            $users=Reviewer::where('trackId',"=",$trackId)
            ->with('user')->get();
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            return view("TrackChair/reviewers")->with([
                'Track' => $track,
                'users' => $users,
                'conferenceReviewerConfiguration'=>$conferenceReviewerConfiguration
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //assigning papers page
    public function assigningPaper($trackId,$userId){
        try{ 
            $hashids = new Hashids('',40); 
            $userId=$hashids->decode($userId)[0]; 
            $trackId=$hashids->decode($trackId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{ 
            $track=tracks::find($trackId);
            $papers=paper::where('trackId',"=",$trackId)->get();
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            return view('TrackChair/assigningPapers')->with([
                'Track' => $track,
                'userId' => $userId,
                'papers' => $papers,
                'conferenceReviewerConfiguration'=>$conferenceReviewerConfiguration
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //assigning paper
    public function assigning(Request $request,$userId){
        try{ 
            $hashids = new Hashids('',40); 
            $userId=$hashids->decode($userId)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{ 
            $papers=$request['paper'];
            if($papers==[]){
                Alert::Alert('Alert','Please Select Papers for Assignment');
                return back();     
            }
            $track=tracks::find($papers[0]);
            foreach($papers as $paper){
                $Paper=paper::find($paper);
                $reviewerPaper=new reviewerPaper;
                $reviewerPaper->PaperId=$Paper->id;
                $reviewerPaper->reviewerId=$userId;
                $reviewerPaper->status="NOT REVIEWED";   
                $reviewerPaper->conferenceId=$Paper->conferenceId;
                $reviewerPaper->trackId=$Paper->trackId;
                $reviewerPaper->save();
            }
            Alert::success('Success','Papers successfully Assigned');
            return back();    
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //displaying all papers
    public function displayPapers($trackId){
        try{ 
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0];   
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{ 
            $track=tracks::find($trackId);
            $papers=paper::where('trackId',"=",$trackId)->with('authors.user')->get();
            $reviewerCount=[];
            foreach($papers as $paper){
                $count=reviewerPaper::where("PaperId",$paper->id)->count();
                array_push($reviewerCount,$count);
            }
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            return view("TrackChair/papers")->with([
                'Track' => $track,
                'papers' => $papers,
                'reviewerCount' => $reviewerCount,
                'conferenceReviewerConfiguration'=>$conferenceReviewerConfiguration
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //assigning reviewers page
    public function assigningReviewer($paperId){
        try{ 
            $hashids = new Hashids('',40); 
            $paperId=$hashids->decode($paperId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{ 
            $paper=paper::where('id','=',$paperId)->with('track')->first();
            $users=Reviewer::where('trackId',"=",$paper->trackId)
            ->with('user')->get();
            $conferenceReviewerConfigurationconferenceReviewerConfiguration::find($paper->conferenceId);
            return view('TrackChair/assigningReviewer')->with([
                'Track' => $paper->track,
                'users' => $users,
                'paperId' => $paperId,
                'conferenceReviewerConfiguration'=>$conferenceReviewerConfiguration
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //assigning reviewer
    public function ReviewerAssigning(Request $request,$paperId){
        try{ 
            $hashids = new Hashids('',40); 
            $paperId=$hashids->decode($paperId)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $users=$request['user'];
            if($users==[]){
                Alert::Warning('Warning','Please Select Users');
                return back();
            }
            $paper=paper::find($paperId);
            foreach($users as $user){
                $reviewerPaper=new reviewerPaper;
                $reviewerPaper->PaperId=$paper->id;
                $reviewerPaper->reviewerId=$user;
                $reviewerPaper->status="NOT REVIEWED";
                $reviewerPaper->conferenceId=$paper->conferenceId;
                $reviewerPaper->trackId=$paper->trackId;
                $reviewerPaper->save();
            }
            Alert::success('Success','Reviewer successfully Assigned');
            return back();
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    // public function checkingreviewsPage($trackId){
    //     $reviews = reviews::
    //     where('trackId', $trackId)
    //     ->get();
    //     $paperNames=[];
    //     foreach ($reviews as $review) {
    //         $paper=paper::where('id',"=",$review{'paperId'})->get('Title')->first();
    //         array_push($paperNames,$paper{'Title'});
    //     }
    //     return view("TrackChair/checkingReviews")->with(["paperNames"=>$paperNames])->with(["reviews"=>$reviews])->with(["trackId"=>$trackId]);
    // }


    //showing conference data
    public function showingConference($trackId){
        try{ 
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $track=tracks::where("id",'=',$trackId)->with('conference')->first();
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($trackId);
            return view("conference/trackchairConference")->with([
                "Track"=>$track,
                'conferenceReviewerConfiguration' => $conferenceReviewerConfiguration,
                "conference"=>$track->conference
                ]);
        }
        catch(\Exception $e){
            abort(404);
        }    
    }


    //editing track review configuration
    // public function editrerviewsconfiguration(Request $request,$trackId){  
    //     try{ 
    //         $hashids = new Hashids('',40); 
    //         $trackId=$hashids->decode($trackId)[0];     
    //     }
    //     catch(\Exception $e){
    //         abort(403,'Unauthorized action.');
    //     }
    //     try{
    //         $reviewconfiguration=conferenceReviewerConfiguration::find($trackId);
    //         $reviewconfiguration->allowreviews=$request->get('allowReviews');
    //         $reviewconfiguration->showReviewerNames=$request->get('showReviewerNames');
    //         $reviewconfiguration->allowSubreviews=$request->get('allowSubreviews');
    //         $reviewconfiguration->save();
    //         Alert::success('Success','Reviewer Configuration Successfully Changed');
    //         return back();    
    //     }
    //     catch(\Exception $e){
    //         abort(404);
    //     }
    // }


    public function paperDataPage($paperId){
        try{ 
            $hashids = new Hashids('',40); 
            $paperId=$hashids->decode($paperId)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try {
            $paper=paper::find($paperId);
            $track=tracks::where('id','=',$paper->trackId)->with('conference')->first();    
            $authors=Authors::where('paperId',"=",$paperId )->with('user')->get();
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($track->conference->id);
            $reviews = reviews::where('paperId', '=',$paperId)->get();
            $reviewers=reviewerPaper::where('paperId',"=",$paperId )->with('user')->get();
            return view('TrackChair/paperData')->with([
                'conferenceReviewerConfiguration'=>$conferenceReviewerConfiguration,
                'Conference' => $track->conference,
                'reviewers' => $reviewers,
                'reviews' => $reviews,
                'Track' => $track,
                'Paper' => $paper,
                'authors' => $authors
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }
    public function addingReviewerWithoutInvitiationPage($trackId){
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
            return view('TrackChair/addReviewerWithoutInvitiation')->with([
                'Track' => $track,
                "conferenceReviewerConfiguration"=>$conferenceReviewerConfiguration
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function addingReviewerWithoutInvitiation(Request $request,$trackId){
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
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            return view('TrackChair/showReviewerDataWithoutInvitiation')->with([
                'Track' => $track,
                'user'=>$user,
                "conferenceReviewerConfiguration"=>$conferenceReviewerConfiguration
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }


    public function addReviewer(Request $request,$trackId){
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
            $Reviewer=new Reviewer;   
            $Reviewer->userId=$user->id;
            $Reviewer->conferenceId=$track->conference->id;
            $Reviewer->Status="ACCEPTED";
            $Reviewer->trackId=$trackId;
            $Reviewer->save(); 
            $trackId=$hashids->encode($trackId); 
            Alert::success('Success','Reviewer successfully Added');
            return redirect()->route('TrackChairDashboard', ['id'=>$trackId]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function showingAllReviewers($trackId){
        try{ 
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $track=tracks::find($trackId);
            $users=Reviewer::where([
                ['trackId',"=",$trackId],
                ['Status',"=",'ACCEPTED']
                ])->with('user')->get();
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            return view('TrackChair/showingReviewers')->with([
                'Track'=>$track,
                'Reviewers'=>$users,
                "conferenceReviewerConfiguration"=>$conferenceReviewerConfiguration
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function notifyingReviewerPage($trackId){
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
            return view('TrackChair/notifying')->with([
                'Track'=>$track,
                "conferenceReviewerConfiguration"=>$conferenceReviewerConfiguration
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function notifyingReviewers(Request $request,$trackId){
        try{ 
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $subject=$request->get('subject');
            $body=$request->get('body');
            $track=tracks::where('id','=',$trackId)->with('conference')->first();
            $users=Reviewer::where('trackId',"=",$trackId)->with('user')->get();
            foreach ($users as $user){
                $email=$user->user->email;
                    $data = array ('conference'=>$track->conference->conferenceName,'body'=>$body,'firstName'=>$user->user->firstName,'lastName'=>$user->user->lastName);
                    Mail :: send (  'Mails.notifying' , $data , function ( $message ) use ($email,$subject){
                        $message -> to ( $email ,"PC member" )-> subject
                        ( $subject );
                        $message -> from ( 'xyz@gmail.com' , 'EasyFit Management Team' );
                    });
            }
            $id=$hashids->encode($trackId);
            Alert::success('Success','Mail successfully send');
            return redirect()->route('TrackChairDashboard', ['id'=>$id]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function allSubmissions($trackId){
        try{ 
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $track=tracks::where('id',$trackId)->with(['papers','papers.authors.user'])->first();
            $reviewerCount=[];
            foreach($track->papers as $paper){
                $count=reviewerPaper::where("PaperId",$paper->id)->count();
                array_push($reviewerCount,$count);
            }
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            return view('TrackChair/allSubmissions')->with([
                'Track'=>$track,
                'count'=>$reviewerCount,
                "conferenceReviewerConfiguration"=>$conferenceReviewerConfiguration
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }    
    }

    public function creatingPoolOfSubreviewersPage($trackId){
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
            return view('TrackChair/creatingPoolOfSubreviewers')->with([
                'Track'=>$track,
                "conferenceReviewerConfiguration"=>$conferenceReviewerConfiguration
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function creatingPoolOfSubreviewers(Request $request,$trackId){
        try{ 
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $track=tracks::where('id','=',$trackId)->with('conference')->get();
            //storing subreviewers data
            $request->validate([
                'data.*.email' => 'required',
            ]);
            foreach ($request->data as $key => $data) {
                $user = User::where('email',$data['email'])->first();
                if($user==null){
                    Alert::error('Error','User not REGISTERED on easyFit');
                    return back();
                }
            }
            foreach($request->data as $key => $data){
                $user = User::where('email',$data['email'])->first();
                $email=$user->email;
                $Subreviewer=new SubReviewer;   
                $Subreviewer->userId=$user->id;
                $Subreviewer->conferenceId=$conference->id;
                $Subreviewer->Status="REQUESTED";
                $Subreviewer->RequestedBy=Auth::id();
                $Subreviewer->trackId=$trackId;
                $Subreviewer->save();
                $data = array ('firstName'=>$user->firstName,'lastName'=>$user->lastName,'FirstName'=>Auth::user()->firstName,'LastName'=>Auth::user()->lastName,'email'=>Auth::user()->email,'track'=>$track->Name,'conference'=>$track->conference->conferenceName);
                Mail :: send (  'Mails.TrackChair.RequestingReviewer' , $data , function ( $message ) use ($email){
                    $message -> to ( $email ,"SubReviewer" )-> subject
                    ('Regarding Requesting as SubReviewer' );
                    $message -> from ( 'xyz@gmail.com' , 'EasyFit Management Team');
                });  
            }
            $trackId=$hashids->encode($trackId); 
            Alert::success('Success','Request sent to all SubReviewers');
            return redirect()->route('TrackChairDashboard', ['id'=>$trackId]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function allSubReviewerPage($trackId){
        try{ 
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $track=tracks::find($trackId);
            $users=SubReviewer::where('trackId',"=",$trackId)->with('user')->get();
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            return view('TrackChair/allSubreviewers')->with([
                'Track'=>$track,
                'users' => $users,
                'conferenceReviewerConfiguration'=>$conferenceReviewerConfiguration
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function showingallReviewPage($trackId){
        try{ 
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $track=tracks::find($trackId);
            $reviews = reviews::
            where('trackId', $trackId)->with('paper')
            ->get();
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            return view('TrackChair/showingAllReviews')->with([
                'Track'=>$track,
                "reviews"=>$reviews,
                "conferenceReviewerConfiguration"=>$conferenceReviewerConfiguration
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function showingAllMissingReviewPage($trackId){
        try{ 
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $reviews=reviewerPaper::where([
                ['trackId','=',$trackId],
                ['status','=','NOT REVIEWED']
            ])->with('paper','user')->get();
            $track=tracks::find($trackId);
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($track->conferenceId);
            return view('TrackChair/missingReviews')->with([
                "Reviews"=>$reviews,
                "Track"=>$track,
                'conferenceReviewerConfiguration'=>$conferenceReviewerConfiguration
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function showingstatusOfSubmissions($trackId){
        try{ 
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $papers=paper::where('trackId','=',$trackId)->get();
            $track=tracks::where('id',$trackId)->with('conference')->first();
            $conferenceReviewerConfiguration=conferenceReviewerConfiguration::find($track->conference->id);
            return view('TrackChair/statusOfSubmission')->with([
                'Track'=>$track,
                'papers'=>$papers,
                'conferenceReviewerConfiguration'=>$conferenceReviewerConfiguration
            ]);
            }
        catch(\Exception $e){
            abort(404);
        }
    }
}
