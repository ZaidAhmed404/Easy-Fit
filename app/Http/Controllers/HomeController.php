<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Superchair;
use App\Models\Trackchair;
use App\Models\Reviewer;
use App\Models\SubReviewer;
use App\Models\Authors;
use App\Models\User;
use Auth;
use App\Models\conference;

use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::id()==1){
            
            return view('Admin/Dashboard')->with(['Conferences'=>conference::all()]);
        }
        $Superchairs=Superchair::where('userId',"=",Auth::id())->with('conference')->get();
        $Trackchairs=Trackchair::where('userId',"=",Auth::id())->with(['conference','track'])->get();
        $Reviewers=Reviewer::where('userId',"=",Auth::id())->with(['conference','track'])->get();
        $SubReviewers=SubReviewer::where('userId',"=",Auth::id())->with(['conference','track'])->get();
        $Authors=Authors::where('userId',"=",Auth::id())->with('conference')->get();
        return view('home')
        ->with([
            'Superchairs' => $Superchairs,
            'Trackchairs' => $Trackchairs,
            'Reviewers' => $Reviewers,
            'SubReviewers' => $SubReviewers,
            'Authors' => $Authors
        ]);
    }

    //editind user data Page
    public function editUserDataPage(){
        
        $user=User::find(Auth::id());
        
        return view('editUserDataPage')
        ->with(['user' => $user]);
        
    }

    //editing user Data
    public function editUserData(Request $request){
    
        $user=User::find(Auth::id());
        $email=$request->get('email');
        $USER=User::where('email',$email)->first();
        if($USER!=null){
            Alert::error('ERROR','Email is already be USED by Another User');
            return back();
        }
        $user->firstName=$request->get('firstName');
        $user->lastName=$request->get('lastName');
        $user->email=$email;
        $user->country=$request->get('country');
        $user->organization=$request->get('organization');
        $user->web=$request->get('web');
        $user->save();
        Alert::success('Success','Profile Data Successfully Edited');
        return redirect('home');
        
    }

    public function about(){
        return view('about');
    }
}
