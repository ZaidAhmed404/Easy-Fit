<?php

namespace App\Http\Controllers;
use App\Models\conference;
use App\Models\tracks;
use App\Models\paper;
use App\Models\Superchair;
use Illuminate\Database\Eloquent\Exception;
use App\Models\Reviewer;
use App\Models\reviewerPaper;
use App\Models\Authors;
use App\Models\Trackchair;
use App\Models\submissionFormConfiguration;
use Auth;
use File;
use Mail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\paperConfiguration;
use App\Models\SubReviewer;
use DB;
use App\Models\conferenceReviewerConfiguration;
use App\Models\reviewerConfiguration;
use RealRashid\SweetAlert\Facades\Alert;
use Hashids\Hashids;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use App\Models\reviews;
class superchairController extends Controller
{
    
    //Displaying conference data
    public function conferenceData($id){
        try {
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0]; 
        } 
        catch (\Exception $e) {
            abort(403, 'Unauthorized action.');
        }
        try{
            $conference=conference::find($id);
            $paperconfiguration=paperConfiguration::find($id);
            $reviewconfiguration=conferenceReviewerConfiguration::find($id);
            $submissionFormConfiguration=submissionFormConfiguration::find($id);
            return view("conference/superChairconferenceData")->with([
                'submissionFormConfiguration' => $submissionFormConfiguration,
                'reviewconfiguration' => $reviewconfiguration,
                'paperconfiguration' => $paperconfiguration,
                'Conference' => $conference
                ]);
        }
        catch(\Exception $e){
            abort(404);
        }    
    }

    //adding new superchair
    public function addingSuperchair($id){
        try{
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference=conference::find($id);
            return view("SuperChair/addingSuperchair")->with([
                'Conference' => $conference
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //showing data of new superchair
    public function showingSuperchair(Request $request,$id){
        try{
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $email=$request->get('email');
            $user = User::where('email',$email)->first();
            if($user==null){
                Alert::error('Relating User','User not REGISTERED on easyFit');
                return back();
            }
            $conference=conference::find($id);        
            return view("SuperChair/showingSuperchairData")->with([
                'Conference' => $conference,
                'user' => $user
                ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //assinging new superchair
    public function assigningSuperchair(Request $request,$id){
        try{
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference=conference::find($id);
            $email=$request->get('email');
            $user = User::where('email',$email)->first();
            $Superchair=new Superchair;
            $Superchair->userId=$user->id;
            $Superchair->conferenceId=$conference->id;
            $Superchair->status='APPROVED';
            $Superchair->save();
            $data = array ('firstName'=>$user->firstName,'lastName'=>$user->lastName,'FirstName'=>Auth::user()->firstName,'LastName'=>Auth::user()->lastName,'email'=>Auth::user()->email,'conference'=>$conference->conferenceName);
            Mail :: send (  'Mails.SuperChair.AddingSuperchairMail' , $data , function ( $message ) use ($email){
                $message -> to ( $email ,"Superchair" )-> subject
                ( 'Regarding Adding Superchair' );
                $message -> from ( 'xyz@gmail.com' , 'EasyFit Management Team');
            });
            $id=$hashids->encode($id); 
            Alert::success('Relating Conference','Superchair role successfully assigned');
            return redirect()->route('conference.show', ['id'=>$id]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //showing notification page
    public function notifyingPage($role,$id){
        try{
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference=conference::find($id);
            return view("SuperChair/notifyingPage")->with([
                'Conference' => $conference,
                'role' => $role
                ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }


    //sending notification
    public function notifying(Request $request,$role,$id){
        try{
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $subject=$request->get('subject');
            $body=$request->get('body');
            $conference=conference::find($id);
            $users;
            $sendTo;
            //emailing reviewers
            if($role=="REVIEWER"){
                $users=Reviewer::where('conferenceId',"=",$conference->id)
                ->with('user')->get();
                $sendTo="PC member";
            }
            //emailing trackchairs
            elseif($role=="TRACKCHAIR"){
                $users=Trackchair::where('conferenceId',"=",$conference->id)
                ->with('user')->get();
                $sendTo="Trackchair";
            }
            //emailing authors
            elseif($role=="AUTHOR"){
                $users=Authors::where([
                    ['conferenceId',"=",$conference->id],
                    ['correcpondindauthor',"=","YES"]
                    ])->with('user')->get();
                $sendTo="Authors";
            }
            elseif($role='Reviewers with Missing Reviews'){
                $users=reviewerPaper::where([
                    ['conferenceId','=',$conference->id],
                    ['status','=','NOT REVIEWED']
                ])->with(['user'])->get();
                $sendTo='PC Member';
            }
            foreach ($users as $user){
                $email=$user->user->email;
                    $data = array ('conference'=>$conference->conferenceName,'body'=>$body,'firstName'=>$user->user->firstName,'lastName'=>$user->user->lastName);
                    Mail :: send ('Mails.notifying' , $data , function ( $message ) use ($email,$subject,$sendTo){
                        $message -> to ( $email ,$sendTo )-> subject
                        ( $subject );
                        $message -> from ( 'xyz@gmail.com' , 'EasyFit Management Team' );
                    });
            }
            $conferenceId=$hashids->encode($id);
            Alert::success('Mail','Mail Successfully Sent');
            return redirect()->route('conference.show', ['id'=>$conferenceId]);
        }
        catch(\Exception $e){
            abort(404);
        }    
    }

    ////showing single trackchair data
    public function showingTrackchairData(Request $request,$id){        
        try{
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $email=$request->get('email');
            $user = User::where('email',$email)->first();
            $track=tracks::where('id','=',$id)->with('conference')->first();
            if($user==null){          
                Alert::error('Relating User','User not REGISTERED on easyFit');
                return back()->with(["message"=>'User not REGISTERED on easyFit']);
            }
            return view('SuperChair/showTrackChairData')->with([
                'Conference' => $track->conference,
                'user' => $user,
                'Track' => $track
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }


    //showing conference statistics
    public function showingConferenceStatistics($id){
        try{
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $generalStatistics=[];
            $generalStatistics[0]=paper::where('conferenceId',$id)->count();
            $generalStatistics[1]=paper::where([
                ['decision','Strong Accept'],
                ['conferenceId',$id]
            ])->count();
            $generalStatistics[2]=reviews::where('conferenceId',$id)->count();
            $generalStatistics[3]=reviewer::where([
                ['conferenceId',$id],
                ['Status','ACCEPTED']
            ])->count();
            if($generalStatistics[0]==0){
                $generalStatistics[4]=0;    
            }
            else{
                $generalStatistics[4]=$generalStatistics[1]/$generalStatistics[0];
            }
            $paperIds= paper::where('conferenceId',$id)->get('id');
            $count = [0,0,0,0,0,0];
            foreach($paperIds as $paperId){
                $countReview= reviews::where('paperId',$paperId->id)->count();
                if($countReview==0){
                    $count[0]++;
                }
                elseif($countReview==1){
                    $count[1]++;
                }
                elseif($countReview==2){
                    $count[2]++;
                }
                elseif($countReview==3){
                    $count[3]++;
                }
                elseif($countReview==4){
                    $count[4]++;
                }
                elseif($countReview==5){
                    $count[5]++;
                } 
            }
            $conference=conference::find($id);
            $tracks=tracks::where("conferenceId",'=',$conference->id)->get();
            $tracksData=[];
            $trackReviewCount=[];
            foreach($tracks as $track){
                $Track=[];
                $Track[0]=$track->Name;
                $Track[1]=paper::where('trackId',$track->id)->count();
                $Track[2]=paper::where([
                    ['decision','Strong Accept'],
                    ['trackId',$track->id]
                ])->count();
                $Track[3]=reviewer::where([
                    ['conferenceId',$id],
                    ['trackId',$track->id],
                    ['Status','ACCEPTED']
                ])->count();
                if($Track[1]==0){
                    $Track[4]=0;
                }
                else{
                    $Track[4]=$Track[2]/$Track[1];
                }
                array_push($tracksData,$Track);
                $papers=paper::where('trackId',$track->id)->get('id');
                $trackData=['',0,0,0,0,0,0,0];
                $trackData[0]=$track->Name;
                foreach($papers as $paper){
                    $countReview= reviews::where('paperId',$paper->id)->count();
                    if($countReview==0){
                        $trackData[1]++;
                    }
                    elseif($countReview==1){
                        $trackData[2]++;
                    }
                    elseif($countReview==2){
                        $trackData[3]++;
                    }
                    elseif($countReview==3){
                        $trackData[4]++;
                    }
                    elseif($countReview==4){
                        $trackData[5]++;
                    }
                    elseif($countReview==5){
                        $trackData[6]++;
                    } 
                }
                array_push($trackReviewCount,$trackData);
            }
            return view('conference/statistic')->with(['trackReviewCount' => $trackReviewCount])->with(['countReview' => $count])->with(['Conference' => $conference])->with(['generalStatistics' => $generalStatistics])->with(['tracksData' => $tracksData]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //approving conference Page
    public function approvingConference($id){
        try{
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference=conference::where('id','=',$id)->with('user')->first();
            return view("Admin/approveConference")->with([
                'conference' => $conference,
                'user' => $conference->user
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //approving conference and assigning role of superchair
    public function approving(Request $request,$conferenceId){ 
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference=conference::where('id','=',$conferenceId)->with('user')->first(); 
            if($conference->approved=="APPROVED"){
                Alert::success('Conference','Conference Already Approved');
                return back();    
            }
            $role=Superchair::where([
                ["userId",'=',$conference->user->id],
                ['Status','=','NOT APPROVED'],
                ["conferenceId",'=',$conferenceId]
            ])->get('id')->first();
            $roleId=$role->id;
            //adding superchair role
            $Superchair=Superchair::find($roleId);
            $Superchair->status="APPROVED";
            $Superchair->save();
            //approving conference
            $conference=conference::find($conferenceId);
            $conference->approved="APPROVED";
            $conference->save();
            //adding paper configuration
            $paperconfiguration=new paperConfiguration;
            $paperconfiguration->id=$conferenceId;
            $paperconfiguration->paperSubmission="YES";
            $paperconfiguration->paperReSubmission="YES";
            $paperconfiguration->showReviews="NO";
            $paperconfiguration->save();
            //reviewer Configuration
            $configuration=new conferenceReviewerConfiguration;
            $configuration->id=$conferenceId;
            $configuration->model="Standard";
            $configuration->showAuthorsNames="YES";
            $configuration->allowStatusMenu="NO";
            $configuration->allowTrackchairStatusMenu="NO";
            $configuration->reviewsAccess="YES";
            $configuration->allowAttachment="YES";
            $configuration->allowReviews="YES";
            $configuration->showReviewerNames="YES";
            $configuration->allowSubreviews="YES";
            $configuration->save();
            //submissions form configurations
            $submissionFormConfiguration=new submissionFormConfiguration;
            $submissionFormConfiguration->id=$conferenceId;
            $submissionFormConfiguration->requirePostalAddress="YES";
            $submissionFormConfiguration->preSubmissionAllowed="NO";
            $submissionFormConfiguration->disableAbstract="NO";
            $submissionFormConfiguration->disableMultipleAuthors="YES";
            $submissionFormConfiguration->fileUpload="YES";
            $submissionFormConfiguration->presenterSelected="YES";
            $submissionFormConfiguration->save();
            //user data
            $email=$conference->user->email;
            //emailing user
            $data = array ('acronym'=>$conference->acronym,'firstName'=>$conference->user->firstName,'lastName'=>$conference->user->lastName,'conference'=>$conference->conferenceName);
                Mail :: send (  'Mails.conferenceApproved' , $data , function ( $message )use ($email){
                    $message -> to ( $email ,"SuperChair" )-> subject
                    ( 'Approved Conference' );
                    $message -> from ( 'xyz@gmail.com' , 'EasyFit Management Team');
            });
            Alert::success('Conference','Conference successfully APPROVED');
            return back();
        }
        catch(\Exception $e){
            abort(404);
        }
    }    
    

    //Creating conference
    public function creatingConference($plan){
        $conferences=conference::where([
            ['userId','=',Auth::id()],
            ['approved','=',"NOT APPROVED"]
            ])->first();
        // return $conferences;
        if($conferences==null){
            return view("SuperChair/CreatingConference")->with(['plan'=>$plan]);
        }
        else{
            Alert::warning('Warning','Sorry for inconvenience.... Previous Conference NOT Approved YET');
            return back();
        }
    }

    //Storing conference data
    public function storingData(Request $request,$plan){
        $conference=new conference;
        $conference->conferenceName= $request->get('conferenceName');
        $conference->acronym= $request->get('acronym');
        $conference->startingDate= $request->get('startingDate');
        $conference->endingDate= $request->get('endingDate');
        $conference->organizerPhoneNumber= $request->get('organizerPhoneNumber');
        $conference->contactEmail= $request->get('contactEmail');
        $conference->Country= $request->get('country');
        $conference->estimatedSubmissions= $request->get('estimatedSubmissions');
        $conference->primaryAim=$request->get('primaryAim');
        $conference->secondaryAim= $request->get('secondaryAim');
        $conference->venue= $request->get('venue');
        $conference->web= $request->get('web');
        $conference->userId=Auth::id();
        if($plan=='Demo'){
            $conference->approved="APPROVED";
        }
        else{
            $conference->approved="NOT APPROVED";
        }
        $conference->save();
        //assigning super chair role
        $Superchair=new Superchair;
        $Superchair->userId=$conference->userId;
        $Superchair->conferenceId=$conference->id;
        if($plan=='Demo'){
            $Superchair->status="APPROVED";
        }
        else{ 
            $Superchair->status="NOT APPROVED";
        }
        if($plan=='Demo'){
            //adding paper configuration
            $paperconfiguration=new paperConfiguration;
            $paperconfiguration->id=$conference->id;
            $paperconfiguration->paperSubmission="YES";
            $paperconfiguration->paperReSubmission="YES";
            $paperconfiguration->showReviews="NO";
            $paperconfiguration->save();
            //reviewer Configuration
            $configuration=new conferenceReviewerConfiguration;
            $configuration->id=$conference->id;
            $configuration->model="Standard";
            $configuration->showAuthorsNames="YES";
            $configuration->allowStatusMenu="NO";
            $configuration->allowTrackchairStatusMenu="NO";
            $configuration->reviewsAccess="YES";
            $configuration->allowAttachment="YES";
            $configuration->allowReviews="YES";
            $configuration->showReviewerNames="YES";
            $configuration->allowSubreviews="YES";
            $configuration->save();
            //submissions form configurations
            $submissionFormConfiguration=new submissionFormConfiguration;
            $submissionFormConfiguration->id=$conference->id;
            $submissionFormConfiguration->requirePostalAddress="YES";
            $submissionFormConfiguration->preSubmissionAllowed="NO";
            $submissionFormConfiguration->disableAbstract="NO";
            $submissionFormConfiguration->disableMultipleAuthors="YES";
            $submissionFormConfiguration->fileUpload="YES";
            $submissionFormConfiguration->presenterSelected="YES";
            $submissionFormConfiguration->save();
            
        }
        $Superchair->save();
        $data = array ('firstName'=>Auth::user()->firstName,'lastName'=>Auth::user()->lastName,'plan'=>$plan,'conference'=>$conference->conferenceName,'Submissions'=>$conference->estimatedSubmissions,'endingDate'=>$conference->endingDate);
            Mail :: send (  'Mails.SuperChair.notifyingAboutChoosingPlan' , $data , function ( $message ){
                $message -> to ( "zaidahmedreal@gmail.com" ,"SuperChair" )-> subject
                ( 'Notifying About Choosing Plan' );
                $message -> from ( 'xyz@gmail.com' , 'EasyFit Management Team');
            });
        if($plan!='Demo'){
            $data = array ('id'=>$conference->id,'acronym'=>$conference->acronym,'conferenceId'=>$conference->id,'firstName'=>Auth::user()->firstName,'lastName'=>Auth::user()->lastName,'Email'=>Auth::user()->email,'conference'=>$conference->conferenceName);
            Mail :: send (  'Mails.SuperChair.RequestingConferenceMail' , $data , function ( $message ){
                $message -> to ( "zaidahmedreal@gmail.com" ,"SuperChair" )-> subject
                ( 'Requesting A Conference' );
                $message -> from ( 'xyz@gmail.com' , 'EasyFit Management Team');
            });
        }
        Alert::success('Alert','Will Assign Role of SuperChair After Approval of Conference');
        return redirect("/home")->with(['message'=>'Will Assign Role of SuperChair After Approval of Conference']);
    
    }

    //displaying conference
    public function showingConference($id) {  
        try {
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0]; 
        } 
        catch (\Exception $e) {   
            abort(403, 'Unauthorized action.');
        }
        try{
            $conference = conference::where('id','=',$id)->with('papers.track','papers.authors.user')->first();  
            return view('SuperChair/showingConference')->with([
                'Conference' => $conference,
                "Papers"=>$conference->papers
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }
        
    //displaying conference all papers
    public function showingConferencePapers($id) {
        try{
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0];
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference = conference::where('id',$id)->with('papers.track','papers.authors.user')->first();
            return view('SuperChair/showingAllPapers')->with([
                'Conference' => $conference,
                "Papers"=>$conference->papers
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }
        
    public function showingConferenceTracks($conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference=conference::where('id','=',$conferenceId)->with('tracks.trackchairs.user')->first();
            return view('SuperChair/showingTracks')->with([
                "Tracks"=>$conference->tracks,
                "Conference"=>$conference
            ]);    
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //showing track page
    public function creatingtrack($id){
        try{
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference = conference::find($id);
            return view("SuperChair/addingTrack")->with([
                'Conference' => $conference
            ]);   
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //storing new track data
    public function storingtrackData(Request $request,$conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            //adding new track
            $tracks=new tracks;
            $tracks->Name = $request->get('name');
            $tracks->shortName = $request->get('shortName');
            $tracks->conferenceId = $conferenceId;
            $tracks->save();
            $conferenceId=$hashids->encode($conferenceId);
            Alert::success('Relating Track','Track Added Successfully'); 
            return redirect()->route('conferenceTracks.show', ['id'=>$conferenceId]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

     //deleting Track data
    public function deleteTrack($trackId) {
        try{
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            tracks::destroy($trackId); 
            Alert::success('Alert','Track Successfully Deleted');
            return back();
        }
        catch(\Exception $e){
            abort(404);
        }
    }


    //Adding TrackChair
    public function showingTrackChairPage($id){
        try{
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $track=tracks::where('id','=',$id)->with('conference')->first();
            return view("TrackChair/addTrackChair")->with([
                'Track' => $track,
                'Conference' => $track->conference
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //Assigning TrackChair
    public function assigningTrackChair(Request $request,$id){
        try{
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $email=$request->get('email');
            $user = User::where('email',$email)->first();
            $firstName=$user->firstName;
            $lastName=$user->lastName;    
            $track=tracks::where('id','=',$id)->with('conference')->first();
            //adding role of trackchair
            $Trackchair=new Trackchair;
            $Trackchair->userId=$user->id;
            $Trackchair->conferenceId=$track->conference->id;
            $Trackchair->trackId=$track->id;
            $Trackchair->save();
            //notifying trackchair
            $data = array ('firstName'=>$firstName,'lastName'=>$lastName,'FirstName'=>Auth::user()->firstName,'LastName'=>Auth::user()->lastName,'email'=>Auth::user()->email,'track'=>$track->Name,'conference'=>$track->conference->conferenceName);
                Mail :: send (  'Mails.SuperChair.AdingTrackChairMail' , $data , function ( $message ) use ($email){
                $message -> to ( $email ,"TrackChair" )-> subject
                ( 'Regarding Adding TrackChair' );
                $message -> from ( 'xyz@gmail.com' , 'EasyFit Management Team');
            });
            $ConferenceId=$hashids->encode($track->conference->id);    
            Alert::success('Success','Trackchair successfully assigned');
            return redirect()->route('conferenceTracks.show', ['id'=>$ConferenceId]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    //editing paper configuration
    public function editpaperConfiguration(Request $request,$id){
        try{
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $paperconfiguration=paperConfiguration::find($id);
            $paperconfiguration->paperSubmission=$request->get('paperSubmission');
            $paperconfiguration->paperReSubmission=$request->get('paperReSubmission');
            $paperconfiguration->save();
            Alert::success('Success','Paper Configuration Successfully Changed');
            return back();
        }
        catch(\Exception $e){
            abort(404);
        }
    }


    //editing paper configuration
    public function editrerviewsConfiguration(Request $request,$conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $reviewconfiguration=conferenceReviewerConfiguration::find($conferenceId);
            $reviewconfiguration->allowreviews=$request->get('allowReviews');
            $reviewconfiguration->showReviewerNames=$request->get('showReviewerNames');
            $reviewconfiguration->allowSubreviews=$request->get('allowSubreviews');
            $reviewconfiguration->showAuthorsNames=$request->get('showAuthorsNames');
            $reviewconfiguration->allowStatusMenu=$request->get('allowStatusMenu');
            $reviewconfiguration->allowTrackchairStatusMenu=$request->get('allowTrackchairStatusMenu');
            $reviewconfiguration->reviewsAccess=$request->get('reviewsAccess');
            $reviewconfiguration->save();
            Alert::success('Success','Reviewer Configuration Successfully Changed');
            return back();
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function paperDataPage($paperId){
        try{
            $hashids = new Hashids('',40); 
            $paperId=$hashids->decode($paperId)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{    
            $paper=paper::where('id','=',$paperId)->with(['track','conference'])->first();
            $authors=Authors::where('paperId',"=",$paperId)->with('user')->get();
            $reviews = reviews::where('paperId', '=',$paperId)->get();
            $reviewers=reviewerPaper::where('paperId',"=",$paperId)->with(['user'])->get();
            return view('SuperChair/paperData')->with([
                'reviewers' => $reviewers,
                'Conference' => $paper->conference,
                'reviews' => $reviews,
                'Track' => $paper->track,
                'Paper' => $paper,
                'authors' => $authors
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function editPaperDecision(Request $request,$paperId){
        try{
            $hashids = new Hashids('',40); 
            $paperId=$hashids->decode($paperId)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{    
            $paper=paper::find($paperId);
            $paper->decision=$request->get('decision');
            $paper->save();
            Alert::success('Success','Paper Decision successfully Edited');
            return back();
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function removingReviewer($paperId,$reviewerId){
        try{
            $hashids = new Hashids('',40); 
            $reviewerId=$hashids->decode($reviewerId)[0];
            $paperId=$hashids->decode($paperId)[0];   
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            reviewerPaper::destroy($reviewerId);
            Alert::success('Success','Reviewer successfully Removed');
            return back();
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function displayingAllSubreviewers($conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference=conference::find($conferenceId);
            $subreviewers=SubReviewer::where('conferenceId',"=",$conferenceId)->with('user')->get();
            return view('SuperChair/displayingAllSubreviewers')->with([
                'Conference'=>$conference,
                'users' => $subreviewers
                ]);    
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function createMultipleSubreviewers($conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference=conference::find($conferenceId);
            $tracks=tracks::where('conferenceId',$conferenceId)->get();
            return view('SuperChair/createMultipleSubreviewers')->with(['tracks'=>$tracks])->with(['Conference'=>$conference]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function creatingPoolOfSubreviewers(Request $request,$conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference=conference::find($conferenceId);
            //storing subreviewers data
            $request->validate([
                'data.*.email' => 'required',
            ]);
            foreach ($request->data as $key => $data) {
                $user = User::where('email',$data['email'])->first();
                if($user==null){
                    Alert::error('ERROR','User not REGISTERED on easyFit');
                    return back()->with(["message"=>'User not REGISTERED on easyFit']);
                }
            }
            foreach($request->data as $key => $data){
                $user = User::where('email',$data['email'])->first();
                $email=$user->email;
                $Subreviewer=new SubReviewer;   
                $Subreviewer->userId=$user->id;
                $Subreviewer->conferenceId=$conferenceId;
                $Subreviewer->Status="REQUESTED";
                $Subreviewer->RequestedBy=Auth::id();
                $Subreviewer->trackId=$data['tracks'];
                $Subreviewer->save();
                $track=tracks::find($data['tracks']);
                $data = array ('firstName'=>$user->firstName,'lastName'=>$user->lastName,'FirstName'=>Auth::user()->firstName,'LastName'=>Auth::user()->lastName,'email'=>Auth::user()->email,'track'=>"$track->Name",'conference'=>$conference->conferenceName);
                Mail :: send (  'Mails.TrackChair.RequestingReviewer' , $data , function ( $message ) use ($email){
                    $message -> to ( $email ,"SubReviewer" )-> subject
                    ( 'Regarding Requesting as SubReviewer' );
                    $message -> from ( 'xyz@gmail.com' , 'EasyFit Management Team');
                });  
            }
            Alert::success('Success','Request send to all subreviewers');
            return back();  
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function displayMissingReviews($conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $reviews=reviewerPaper::where([
                ['conferenceId','=',$conferenceId],
                ['status','=','NOT REVIEWED']
            ])->with(['user','paper'])->get();
            
            $conference=conference::find($conferenceId);
            return view('SuperChair/displayMissingReviews')->with([
                "Conference"=>$conference,
                "Reviews"=>$reviews
                ]);
        }   
        catch(\Exception $e){
            abort(404);
        } 
        
    }

    public function displayAllReviews($conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{    
            $conference=conference::find($conferenceId);
            $reviews = reviews::
            where('conferenceId', $conferenceId)->with(['user','paper'])
            ->get();
            
            return view('SuperChair/displayingAllReviews')->with([
                "reviews"=>$reviews,
                "Conference"=>$conference
                ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function sendingReviewsToAuthors($conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $paperConfiguration=paperConfiguration::find($conferenceId);
            $paperConfiguration->showReviews="YES";
            $paperConfiguration->save();
            Alert::success('Success','Reviews Sent to Authors');
            return back();
        }
        catch(\Exception $e){
            abort(404);
        }    
    }

    public function displayingAllPCMembers($conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $users=Reviewer::where([
                ['conferenceId',"=",$conferenceId],
                ])
            ->with('user','track')->get();
            $conference=conference::find($conferenceId);
            return view('SuperChair/displayingAllPCMembers')->with([
                "Conference"=>$conference,
                'Reviewers'=>$users
                ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function assigningPCMemberToPaper($userId,$trackId){
        try{
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0];
            $hashids = new Hashids('',40); 
            $userId=$hashids->decode($userId)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $papers=paper::where('trackId',"=",$trackId)->with(['track',])->get();
            $track=tracks::where('id','=',$trackId)->with('conference')->first();
            return view('SuperChair/assigningPCMemberToPaper')->with([
                'papers' => $papers,
                'userId' => $userId,
                "Conference"=>$track->conference
                ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function displayingAllSubmissions($conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $papers=paper::where('conferenceId',"=",$conferenceId)->with('authors.user','track')->get();
            $conference=conference::find($conferenceId);
            $reviewerCount=[];
            foreach($papers as $paper){
                $count=reviewerPaper::where("PaperId",$paper->id)->count();
                array_push($reviewerCount,$count);
            }
            return view('SuperChair/displayingAllSubmissions')->with([
                "Conference"=>$conference,
                'papers' => $papers,
                "reviewerCount"=>$reviewerCount
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function assigningPaperToPCMember($paperId){
        try{
            $hashids = new Hashids('',40); 
            $paperId=$hashids->decode($paperId)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try {
            $paper=paper::where('id','=',$paperId)->with(['track','conference'])->first();       
            $users=Reviewer::where('trackId',"=",$paper->trackId)->with('user')->get();
            return view('SuperChair/assigningPaperToPCMember')->with([
                'Conference' => $paper->conference,
                'users' => $users,
                'paperId' => $paperId
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }  
    }

    public function showingAllReviewers($conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $users=Reviewer::where('conferenceId',"=",$conferenceId)->with(['user','track'])->get();
            $conference=conference::find($conferenceId);
            return view('SuperChair/showingAllReviewers')->with([
                "Conference"=>$conference,
                'Reviewers'=>$users
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function invitingPCMember($conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference=conference::find($conferenceId);
            $tracks=tracks::where('conferenceId',$conferenceId)->get();
            return view('SuperChair/invitingPCMember')->with([
                'Conference'=>$conference,
                'Tracks'=>$tracks
                ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function displayPCmemberData(Request $request,$conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $email=$request->get('email');
            $trackId=$request->get("track");
            $user = User::where('email',$email)->first();
            if($user==null){        
                Alert::error('Error','User NOT Registered on EasyFit');
                return back()->with(["message"=>'User not REGISTERED on easyFit']);
            }
            $track=tracks::where('id','=',$trackId)->with('conference')->first();
            return view('SuperChair/displayPCmemberData')->with([
                'Conference'=>$track->conference,
                'Track'=>$track,
                'user'=>$user
                ]);
        }
        catch(\Exception $e){
            abort(404);
        }
        
    }

    
    public function sendingRequestToReviewer(Request $request,$trackId){
        try{
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0];
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $email = $request->get('email');
            $user = User::where('email',$email)->first();
            $track = tracks::where('id','=',$trackId)->with('conference')->first();
            
            $Reviewer = new Reviewer;   
            $Reviewer->userId = $user->id;
            $Reviewer->conferenceId = $track->conference->id;
            $Reviewer->Status = "REQUESTED";
            $Reviewer->trackId = $trackId;
            $Reviewer->save();    
            $data = array ('firstName'=>$user->firstName,'lastName'=>$user->lastName,'FirstName'=>Auth::user()->firstName,'LastName'=>Auth::user()->lastName,'email'=>Auth::user()->email,'track'=>$track->Name,'conference'=>$track->conference->conferenceName);
            Mail :: send ('Mails.TrackChair.RequestingReviewer', $data , function ( $message ) use ($email){
                $message -> to ( $email ,"Reviewer" )-> subject
                ( 'Regarding Requesting as Reviewer' );
                $message -> from ( 'xyz@gmail.com' , 'EasyFit Management Team');
            });
            $id=$hashids->encode($track->conference->id);
            Alert::success('Success','Request successfully Sent to Reviewer');
            return redirect()->route('conference.show', ['id'=>$id]);
        }
        catch(\Exception $e){
            abort(404);
        }            
    }


    public function addingPCMemberWithoutInivitationPage($conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];    
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference=conference::find($conferenceId);
            $tracks=tracks::where('conferenceId',$conferenceId)->get();
            return view('SuperChair/addingPCMemberWithoutInivitationPage')->with(['Tracks'=>$tracks])->with(['Conference'=>$conference]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function ShowingDataOfPCMember(Request $request,$conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $email=$request->get('email');
            $trackId=$request->get("track");
            $user = User::where('email',$email)->first();
            if($user==null){
                Alert::error('Error','User NOT Registered on EasyFit');
                return back()->with(["message"=>'User not REGISTERED on easyFit']);
            }
            $track=tracks::where('id','=',$trackId)->with('conference')->first();
            return view('SuperChair/ShowingDataOfPCMember')->with([
                'Conference'=>$track->conference,
                'Track'=>$track,
                'user'=>$user
                ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function addingPCMemberWithoutInvitation(Request $request,$trackId){
        try{
            $hashids = new Hashids('',40); 
            $trackId=$hashids->decode($trackId)[0];
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $email = $request->get('email');
            $user = User::where('email',$email)->first();
            $track = tracks::where('id','=',$trackId)->with('conference')->first();
            $Reviewer = new Reviewer;   
            $Reviewer->userId = $user->id;
            $Reviewer->conferenceId = $track->conference->id;
            $Reviewer->Status = "ACCEPTED";
            $Reviewer->trackId = $trackId;
            $Reviewer->save();    
            $data = array ('firstName'=>$user->firstName,'lastName'=>$user->lastName,'FirstName'=>Auth::user()->firstName,'LastName'=>Auth::user()->lastName,'email'=>Auth::user()->email,'track'=>$track->Name,'conference'=>$track->conference->conferenceName);
            Mail :: send ('Mails.TrackChair.RequestingReviewer', $data , function ( $message ) use ($email){
                $message -> to ( $email ,"Reviewer" )-> subject
                ( 'Regarding Requesting as Reviewer' );
                $message -> from ( 'xyz@gmail.com' , 'EasyFit Management Team');
            });
            $id=$hashids->encode($track->conference->id);
            Alert::success('Success','Successfully Added PC member');
            return redirect()->route('conference.show', ['id'=>$id]);    
        }
        catch(\Exception $e){
            abort(404);
        } 
    }

    public function editSubmissionFormConfiguration(Request $request,$conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $submissionFormConfiguration=submissionFormConfiguration::find($conferenceId);
            $submissionFormConfiguration->requirePostalAddress=$request->get('requirePostalAddress');
            $submissionFormConfiguration->preSubmissionAllowed=$request->get('preSubmissionAllowed');
            $submissionFormConfiguration->disableAbstract= $request->get('disableAbstract');
            $submissionFormConfiguration->disableMultipleAuthors= $request->get('disableMultipleAuthors');
            $submissionFormConfiguration->fileUpload= $request->get('fileUpload');
            $submissionFormConfiguration->presenterSelected= $request->get('presenterSelected');
            $submissionFormConfiguration->save();
            Alert::success('Success','Submission Form Configuration Successfully Changed');
            return back();
        
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function selectingPlan(){
        try{    
            return view('SuperChair/planChoosing');
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function statusOfSubmissions($conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference = conference::find($conferenceId);
            $papers=paper::where("conferenceId",'=',$conferenceId)->with('authors.user','track')->get();       
            return view('SuperChair/statusOfSubmissions')->with([
                'Conference' => $conference,
                "Papers"=>$papers
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function downloadZip($conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $zip = new ZipArchive;
            $conference=conference::find($conferenceId);
            $fileName = $conference->conferenceName.'.zip';
            if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE){
                $files = File::files(storage_path('app/public'));
                foreach ($files as $key => $value) {
                    $relativeNameInZipFile = basename($value);
                    $file=explode('_', $relativeNameInZipFile);
                    if($file[0]==$conferenceId){
                        $zip->addFile($value,$relativeNameInZipFile);
                    }
                }   
                $zip->close();
            }
            return response()->download(public_path($fileName));
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function conferenceSuperchairs($conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference=conference::where('id',$conferenceId)->with('superchairs.user')->first();
            return view('SuperChair/conferenceSuperchairs')->with([
                'Conference'=>$conference
            ]);   
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function conferenceTrackchairs($conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference=conference::where('id',$conferenceId)->with('trackchairs.user','trackchairs.track')->first();
            return view('SuperChair/conferenceTrackchairs')->with([
                'Conference'=>$conference
            ]);     
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function downloadingExcel($conferenceId){
        try{
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference=conference::find($conferenceId);
            $papers = paper::where('conferenceId','=',$conferenceId)->with('track')->get();
            $export = fopen($conference->conferenceName.".csv", "w");
            fputcsv($export, ["Title","Abstract","Track","FileName","Keywords","Decision"]);
            foreach ($papers as $paper) {
                fputcsv($export, [$paper->Title,$paper->Abstract,$paper->track->Name,$paper->PaperFileName,$paper->tags,$paper->decision]);
            }
            fclose($export);

            return response()->download(public_path($conference->conferenceName.'.csv'));
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    public function deleteRole($id,$role){
        try{
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0];
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            if($role=='Reviewer'){
                Reviewer::destroy($id);   
                Alert::success('Success','Reviewer Successfully Removed');
            }
            elseif($role=='Subreviewer'){
                SubReviewer::destroy($id);   
                Alert::success('Success','Subreviewer Successfully Removed');
            }
            elseif($role=='Superchair'){
                Superchair::destroy($id);   
                Alert::success('Success','Superchair Successfully Removed');       
            }
            elseif($role=='Trackchair'){
                Trackchair::destroy($id);   
                Alert::success('Success','Trackchair Successfully Removed');         
            }
            return back();
        }
        catch(\Exception $e){
            abort(404);
        }
    }
}