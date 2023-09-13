<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\paper;
use App\Models\User;
use App\Models\tracks;
use Auth;
use App\Models\reviewerPaper;
use App\Models\Authors;
use App\Models\reviews;
use App\Models\Superchair;
use App\Models\submissionFormConfiguration;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Reviewer;
use App\Models\Trackchair;
use App\Models\conference;
use Mail;
use DB;
use App\Models\paperConfiguration;
use Hashids\Hashids;
use App\Models\conferenceReviewerConfiguration;
use Illuminate\Database\Eloquent\Exception;
class authorController extends Controller
{

    //make submission
    public function makesubmission(){       

        $conferences=conference::where('approved',"=","APPROVED")->get();
        return view("Author/makeSubmission")->with([
            'Conferences' => $conferences
        ]);
    
    }

    //showing single conference data
    public function singleconferenceData($id){
        try{  
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{ 
            $conference=conference::find($id);
            return view("conference/singleConferenceData")->with([
                'conference' => $conference
            ]);     
        }
        catch(\Exception $e){
            abort(404);
        }
    }
    
    //choosing tracks page
    public function chooseTracks($id){
        try{  
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $conference = conference::find($id);
            $paperconfiguration=paperConfiguration::find($id);        
            $author=Authors::where([
                ['conferenceId','=',$id],
                ['userId','=',Auth::id()]
                ])->first();
            if($author!=null){
                Alert::error('Error','Paper Already Submitted In this conference');
                return back();
            }
            $superchair=Superchair::where([
                ['conferenceId','=',$id],
                ['userId','=',Auth::id()]
                ])->first();
            if($superchair!=null){
                Alert::error('Error','You are Superchair of this Conference So You can\'t upload paper in this conference');
                return back();
            }
            if($paperconfiguration->paperSubmission!="YES"){
                Alert::error('Error','Not accepting Papers Currently');
                return back();
            }
            $tracks=tracks::where('conferenceId',"=",$id)->get();
            return view("Author/choosingTracks")->with([
                "Tracks"=>$tracks,
                'conferenceId' => $conference->id
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    ////showing single Author data
    public function showingAuthorData(Request $request,$conferenceId,$trackId,$paperId){
        try{  
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0];
            $trackId=$hashids->decode($trackId)[0];
            $paperId=$hashids->decode($paperId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{ 
            $email=$request->get('email');
            $user = User::where('email',$email)->first();
            $correcpondingAuthor=$request->get('correcpondingAuthor');
            if($user==null){
                Alert::error('Error','User not REGISTERED on easyFit');
                return back();
            }
            $paper=paper::find($paperId);
            return view('Author/showingAuthorData')->with([
                'Paper' => $paper,
                'correcpondingAuthor' => $correcpondingAuthor,
                'user' => $user,
            ]); 
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    
    //storing Single Author
    public function create($conferenceId,$trackId,$paperId){
        try{ 
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0]; 
            $trackId=$hashids->decode($trackId)[0]; 
            $paperId=$hashids->decode($paperId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $paper=paper::find($paperId);
            return view("Author/Create")->with([
                'Paper' => $paper,
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }



    //local storing tracks
    public function choosingTracks(Request $request,$conferenceId){
        try{ 
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $conference = conference::find($conferenceId);
            $trackId=$request->get("track");
            $track=tracks::find($trackId);
            $conferenceId=$hashids->encode($conferenceId);
            $trackId=$hashids->encode($track->id);  
            return redirect()->route('paperuploading', ['conferenceid' => $conferenceId,'trackid'=>$trackId]);    
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    
    //paper submitting page
    public function paperSubmittingPage($conferenceId,$trackId){
        try{  
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0]; 
            $trackId=$hashids->decode($trackId)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{ 
            $submissionFormConfiguration=submissionFormConfiguration::find($conferenceId);
            return view("Author/papersubmitting")->with([
                'submissionFormConfiguration' => $submissionFormConfiguration,
                'conferenceId' => $conferenceId,
                'trackId' => $trackId
            ]);     
        }
        catch(\Exception $e){
            abort(404);
        }
    }
    
    
    //Storing Author and Paper Data
    public function paperSubmitting(Request $request,$conferenceId,$TrackId){
        try{ 
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0]; 
            $TrackId=$hashids->decode($TrackId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{     
            //storing authors data
            $request->validate([
                'data.*.email' => 'required',
            ]);
            $users="";
            foreach ($request->data as $key => $data) {                
                $user = User::where('email',$data['email'])->first();
                if($user==null){
                    Alert::error('Error','User not REGISTERED on easyFit');
                    return back();
                }
                $users=$users.$user->firstName." ".$user->lastName." ; ";  
            }
            if($request->file('file')!=null){
                $guessExtension = $request->file('file')->guessExtension();
                if($guessExtension!='pdf'){
                    Alert::error('Error','File Type is other than PDF.Please Upload on PDF file');
                    return back();
                }
            }
            
            $track=tracks::where('id','=',$TrackId)->with('conference')->first();
            
            //storing paper data
            $paper=new paper;
            $title=$request->get('title');
            $paper->Title=$title;
            $paper->Abstract=$request->get('abstract');
            $paper->PaperFileName=$track->conference->id.'_'.$TrackId.'_'.Auth::id();
            $paper->trackId=$TrackId;
            $paper->conferenceId=$track->conference->id;
            $paper->tags=$request->get('tags');
            $paper->decision="";
            $paper->submittedBy=Auth::id();
            $paper->save();
            $PAPER=paper::find($paper->id);
            $PAPER->PaperFileName=$track->conference->id.'_'.$TrackId.'_'.$paper->id;
            $PAPER->save();
            //storing file
            if($request->file('file')!=null){
                $request->file('file')->storeAs("public",$track->conference->id.'_'.$TrackId.'_'.$paper->id.'.'.$guessExtension);
            }
            foreach ($request->data as $key => $data) {
                $user = User::where('email',$data['email'])->first();
                $author=new Authors;    
                $author->userId=$user->id;
                $author->conferenceId=$track->conference->id;
                $author->trackId=$TrackId;
                $author->paperId=$paper->id;
                if (array_key_exists("postalAddress",$data))
                {
                    $author->postalAddress=$data['postalAddress'];
                }
                $author->correcpondindauthor=$data['correcpondingAuthor'];
                $author->save();
                //email corresponding authors
                if($data['correcpondingAuthor']=="YES"){
                    $Email=$user->email;
                    $data = array ('PaperId'=>$paper->id,'users' => $paper->authorsName,'title'=>$title,'track'=>$track->Name,'conference'=>$track->conference->conferenceName,'acronym'=>$track->conference->acronym,'authenticatedUser'=>Auth::user()->firstName,'lastName'=>Auth::user()->lastName,'authenticatedEmail'=>Auth::user()->email);
                        Mail :: send (  'Mails.Authors.mail' , $data , function ( $message ) use ($Email){
                            $message -> to ( $Email ,"Author" )-> subject
                            ( 'Regarding Your Paper Submission' );
                            $message -> from ( 'xyz@gmail.com' , 'EasyFit Management Team' );
                        });
                }
            }
            //emailing superchair
            $Users=Superchair::where('conferenceId',"=",$conferenceId)->with('user')->get();
            foreach ($Users as $user){
                $Email=$user->user->email;
                $data = array ('PaperId'=>$paper->id,'users' => $users,'title'=>$title,'track'=>$track->Name,'conference'=>$track->conference->conferenceName,'acronym'=>$track->conference->acronym,'authenticatedUser'=>Auth::user()->firstName,'lastName'=>Auth::user()->lastName,'authenticatedEmail'=>Auth::user()->email);
                Mail :: send (  'Mails.Authors.NotifyingSuperChairTrackChair' , $data , function ( $message ) use ($Email){
                    $message -> to ( $Email ,"Superchair" )-> subject
                    ( 'Regarding Paper Submission' );
                    $message -> from ( 'xyz@gmail.com' , 'EasyFit Management Team' );
                });
            } 
            //emailing trackchair
            $Users=Trackchair::where([
                ['conferenceId',"=",$conferenceId],['trackId',"=",$TrackId]
                ])->with('user')->get();

            foreach ($Users as $user){
                $Email=$user->user->email;
                $data = array ('PaperId'=>$paper->id,'users' => $users,'title'=>$title,'track'=>$track->Name,'conference'=>$track->conference->conferenceName,'acronym'=>$track->conference->acronym,'authenticatedUser'=>Auth::user()->firstName,'lastName'=>Auth::user()->lastName,'authenticatedEmail'=>Auth::user()->email);
                Mail :: send (  'Mails.Authors.NotifyingSuperChairTrackChair' , $data , function ( $message ) use ($Email){
                    $message -> to ( $Email ,"Trackchair" )-> subject
                    ( 'Regarding Paper Submission' );
                    $message -> from ( 'xyz@gmail.com' , 'EasyFit Management Team' );
                });
            }
            return redirect('/home');
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    
    //Displaying Author DashBoard
    public function dashBoard($paperId){
        try{  
            $hashids = new Hashids('',40); 
            $paperId=$hashids->decode($paperId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $paper=paper::where('id','=',$paperId)->with(['track','conference','authors.user'])->first();
            return view("Author/Dashboard")->with([
                'Paper'=>$paper
            ]);    
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    
    //Storing Single Author data
    public function storeData(Request $request,$conferenceId,$trackId,$paperId){
        try{ 
            $hashids = new Hashids('',40); 
            $conferenceId=$hashids->decode($conferenceId)[0]; 
            $trackId=$hashids->decode($trackId)[0]; 
            $paperId=$hashids->decode($paperId)[0];  
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            $email=$request->get('email');
            $found="NOT FOUND";
            $user = User::where('email',$email)->first();
            $author=new Authors;    
            $author->userId=$user->id;
            $author->conferenceId=$conferenceId;
            $author->trackId=$trackId;
            $author->paperId=$paperId;
            $correcpondingAuthor=$request->get('correcpondingAuthor');
            $author->correcpondindauthor=$correcpondingAuthor;
            $author->save();
            $paper=paper::where('id','=',$paperId)->with(['conference','track','authors.user'])->first();            
            $authors="";
            foreach($paper->authors as $author){
                $authors=$authors.$author->user->firstName." ".$author->user->lastName." ; ";
            }
            if($correcpondingAuthor=="YES"){
                $data = array ('conference'=>$paper->conference->conferenceName,'PaperId'=>$paperId,'authors' => $authors,'firstName'=>$user->firstName,'lastName'=>$user->lastName,'authorfirstName'=>Auth::user()->firstName,'authorlastName'=>Auth::user()->lastName,'email'=>Auth::user()->email,'groupId'=>$paperId,'title'=>$paper->Title,'track'=>$paper->track->Name);
                Mail :: send (  'Mails.Authors.AuthorMail' , $data , function ( $message ) use ($email){
                    $message -> to ( $email ,"Author" )-> subject
                    ( 'Regarding Adding more Authors to your Paper' );
                    $message -> from ( 'xyz@gmail.com' , 'EasyFit Management Team' );
                });
            }
            $paperId=$hashids->encode($paperId); 
            Alert::success('Success','Author successfully added');
            return redirect()->route('Paper.view', ['id'=>$paperId]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    
    //all Authors
    // public function allAuthors($paperId) {
        
    //     $paper=paper::find($paperId);
    //     $userIds=Authors::where('paperId',"=",$paperId )->pluck('userId');
    //     $users = DB::table('users')->whereIn('id', $userIds)->get();
    //     return view('Author/allAuthors')->with(['paper' => $paper])->with(['users' => $users]);
    
    //     }

    
    //deleting author data
    public function delete($paperId,$userId) {
        try{  
            $hashids = new Hashids('',40); 
            $userId=$hashids->decode($userId)[0]; 
            $paperId=$hashids->decode($paperId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{
            Authors::destroy($userId);
            if($userId==Auth::id()){    
                Alert::warning('Warning','Author successfully Removed');
                return redirect('home');
            }
            else{
                Alert::warning('Warning','Author successfully Removed');
                return back();
            }
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    
    //editing Paper data 
    public function editPaper($paperId){
        try{ 
            $hashids = new Hashids('',40); 
            $paperId=$hashids->decode($paperId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $paper = paper::find($paperId);
            return view('Author/AuthorPaperEditPage')->with([
                'Paper' => $paper
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    
    //uploading edited paper data
    public function updatePaper(Request $request, $paperId){
        try{  
            $hashids = new Hashids('',40); 
            $paperId=$hashids->decode($paperId)[0];     
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $paper = paper::find($paperId);
            $paper->Title=$request->get('title');
            $paper->Abstract=$request->get('abstract');
            $paper->tags=$request->get('tags');
            $paper->save();
            $paperId=$hashids->encode($paperId); 
            Alert::success('Success','Paper successfully Edited');
            return redirect()->route('Paper.view', ['id'=>$paperId]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }
    
    
    //Updating file
    public function updateFile(Request $request,$id){
        try{ 
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0];  
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $guessExtension = $request->file('file')->guessExtension();
            if($guessExtension!='pdf'){    
                Alert::error('Error',"Can't upload other file than pdf");
                return back();
            }
            else{
                $paper = paper::find($id);
                $filename=$paper->PaperFileName;
                $request->file('file')->storeAs("public",$filename.'.'.$guessExtension);
            }
            Alert::success('Success',"File Successfully Re-Uploaded");
            return back();
        }
        catch(\Exception $e){
            abort(404);
        }
    }
    
    //downloading file
    public function download(Request $request,$id){
        try{  
            $hashids = new Hashids('',40); 
            $id=$hashids->decode($id)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{ 
            $paper = paper::find($id);
            $filename=$paper->PaperFileName;
            $fileName='public/'.$filename.'.pdf';
            try{
                return Storage::download($fileName);
            }
            catch(\Exception $e){
                Alert::error("Error","NO File is Uploaded");
                return back();
            }
        }
        catch(\Exception $e){
            abort(404);
        }
    }

    
    //paper view
    public function paperView($paperId){
        try{ 
            $hashids = new Hashids('',40); 
            $paperId=$hashids->decode($paperId)[0];      
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{  
            $paper=paper::where('id','=',$paperId)->with(['track','conference','authors.user','reviews.user'])->first();        
            $paperconfiguration=paperConfiguration::find($paper->conferenceId);
            $reviewerConfiguration=conferenceReviewerConfiguration::find($paper->conferenceId);
            return view("Author/PaperPage")->with([
                "Paper"=>$paper,
                'reviewerConfiguration' => $reviewerConfiguration,
                'paperconfiguration' => $paperconfiguration,
            ]);
        }
        catch(\Exception $e){
            abort(404);
        }
    }


    //showing conference data
    public function showingConference($paperId){
        try{ 
            $hashids = new Hashids('',40); 
            $paperId=$hashids->decode($paperId)[0]; 
        }
        catch(\Exception $e){
            abort(403,'Unauthorized action.');
        }
        try{ 
            $paper=paper::where('id','=',$paperId)->with('conference')->first();
            return view("conference/authorConference")->with([
                "Paper"=>$paper,
                
            ]);     
        }
        catch(\Exception $e){
            abort(404);
        }
    }
}