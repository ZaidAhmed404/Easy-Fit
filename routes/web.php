<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| 
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| 
*/
Route::match(['get', 'post'], '/', function () {
    return view("welcome");
});

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('login','Auth\LoginController@login')->name('login');

Auth::routes();

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('home');

Route::get('about', 'App\\Http\\Controllers\\HomeController@about')->middleware(['auth', 'verified'])->name('about');

//edit user Data Page
Route::get('editUserDataPage','App\\Http\\Controllers\\HomeController@editUserDataPage')->middleware(['auth', 'verified'])->name('editUserDataPage');

//editing user Data 
Route::post('editUserData','App\\Http\\Controllers\\HomeController@editUserData')->middleware(['auth', 'verified'])->name('editUserData');

//approving conference Page
Route::get('approvingConference/{id}','App\\Http\\Controllers\\superchairController@approvingConference')->name('approvingConference');

//approving conference
Route::post('approvingConference/{id}','App\\Http\\Controllers\\superchairController@approving')->name('conference.approve');

//Author page after registration
Route::get('makesubmission','App\\Http\\Controllers\\authorController@makesubmission')->middleware(['auth', 'verified'])->name('makesubmission');

//choosing tracks for submitting papers
Route::get('choosingTracks/{id}','App\\Http\\Controllers\\authorController@chooseTracks')->middleware(['auth', 'verified'])->name('choose.track');

//selected tracks for paper
Route::post('choosingTracks/{id}','App\\Http\\Controllers\\authorController@choosingTracks')->middleware(['auth', 'verified'])->name("trackChoosed");

//selected tracks for paper
Route::get('papersubmitting/{conferenceid}/{trackid}','App\\Http\\Controllers\\authorController@paperSubmittingPage')->middleware(['auth', 'verified'])->name("paperuploading");

//selected tracks for paper
Route::post('papersubmitting/{conferenceid}/{trackid}','App\\Http\\Controllers\\authorController@paperSubmitting')->middleware(['auth', 'verified'])->name("paper.submit");

//displaying author Dashboard
Route::get('authorDashboard/{id}','App\\Http\\Controllers\\authorController@dashBoard')->middleware(['auth', 'verified'])->name('AuthorDashboard');

//displaying all Authors
Route::get('allAuthors/{id}','App\\Http\\Controllers\\authorController@allAuthors')->middleware(['auth', 'verified'])->name('allAuthors');

//displaying only author page
Route::get('author/{conferenceId}/{trackId}/{paperId}','App\\Http\\Controllers\\authorController@create')->middleware(['auth', 'verified'])->name('Author.create');

//posting author data into server
Route::post('author/{conferenceId}/{trackId}/{paperId}','App\\Http\\Controllers\\authorController@storeData')->middleware(['auth', 'verified'])->name('Author.storeData');

//showing single author data
Route::post('showingAuthorData/{conferenceId}/{trackId}/{paperId}', 'App\\Http\\Controllers\\authorController@showingAuthorData')->middleware(['auth', 'verified'])->name('showingAuthorData');


//deleting single author data
Route::get('Author/delete/{paperId}/{id}', 'App\\Http\\Controllers\\authorController@delete')->middleware(['auth', 'verified'])->name('Author.delete');

//Paper editing page
Route::get('Paper/edit/{id}', 'App\\Http\\Controllers\\authorController@editPaper')->middleware(['auth', 'verified'])->name('Paper.edit');

//Paper updating
Route::post('Paper/update/{id}', 'App\\Http\\Controllers\\authorController@updatePaper')->middleware(['auth', 'verified'])->name('Paper.update');

//displaying author conference
Route::get('showingAuthorConference/{id}','App\\Http\\Controllers\\authorController@showingConference')->middleware(['auth', 'verified'])->name('showingAuthorConference');

//single conference Data
Route::get('singleconferenceData/{id}', 'App\\Http\\Controllers\\authorController@singleconferenceData')->middleware(['auth', 'verified'])->name('singleconference.Data');

//downloading file
Route::get('FileDownloading/{id}','App\\Http\\Controllers\\authorController@download')->middleware(['auth', 'verified'])->name("File.downloading");

//reuploading file
Route::post('FileUpdating/{id}','App\\Http\\Controllers\\authorController@updateFile')->middleware(['auth', 'verified'])->name("File.upload");

//displaying paper
Route::get('Paper/{id}','App\\Http\\Controllers\\authorController@paperView')->middleware(['auth', 'verified'])->name("Paper.view");

//Superchair dashboard
Route::get('superchairDashboard','App\\Http\\Controllers\\superchairController@dashBoard')->middleware(['auth', 'verified'])->name('SuperChairDashboard');

//Superchair dashboard
Route::get('selectingPlan','App\\Http\\Controllers\\superchairController@selectingPlan')->middleware(['auth', 'verified'])->name('selectingPlan');


//Editing conference paper Configuration
Route::post('editpaperConfiguration/{id}', 'App\\Http\\Controllers\\superchairController@editpaperConfiguration')->middleware(['auth', 'verified'])->name('editpaperConfiguration');

//Editing conference paper Configuration
Route::post('editSubmissionFormConfiguration/{id}', 'App\\Http\\Controllers\\superchairController@editSubmissionFormConfiguration')->middleware(['auth', 'verified'])->name('editSubmissionFormConfiguration');


//Editing conference review Configuration
Route::post('editreviewConfiguration/{id}', 'App\\Http\\Controllers\\superchairController@editrerviewsConfiguration')->middleware(['auth', 'verified'])->name('editreviewsConfiguration');

//adding superchair
Route::get('addingSuperchair/{id}','App\\Http\\Controllers\\superchairController@addingSuperchair')->middleware(['auth', 'verified'])->name('superchair.add');

//adding superchair
Route::post('showingSuperchair/id/{id}','App\\Http\\Controllers\\superchairController@showingSuperchair')->middleware(['auth', 'verified'])->name('superchair.show');

//assigning superchair
Route::post('assigningSuperchair/{id}','App\\Http\\Controllers\\superchairController@assigningSuperchair')->middleware(['auth', 'verified'])->name('superchair.assigning');

//notifying page
Route::get('notifying/{role}/{id}','App\\Http\\Controllers\\superchairController@notifyingPage')->middleware(['auth', 'verified'])->name('notifyingPage');

//notifying page
Route::post('notifying/{role}/{id}','App\\Http\\Controllers\\superchairController@notifying')->middleware(['auth', 'verified'])->name('notifying');


//assigning PC member to papers
Route::get('assigningPCMemberToPaper/{userId}/{trackId}','App\\Http\\Controllers\\superchairController@assigningPCMemberToPaper')->middleware(['auth', 'verified'])->name("assigningPCMemberToPaper");


//creating conference
Route::get('creatingConference/{plan}','App\\Http\\Controllers\\superchairController@creatingConference')->middleware(['auth', 'verified'])->name('conference.create');

//posting conference into server
Route::post('creatingConference/{plan}','App\\Http\\Controllers\\superchairController@storingData')->middleware(['auth', 'verified'])->name('conference.storeData');

//showing conference
Route::get('conference/{id}', 'App\\Http\\Controllers\\superchairController@showingConference')->middleware(['auth', 'verified'])->name('conference.show');

//showing conference statistics
Route::get('conferenceStatistics/{id}', 'App\\Http\\Controllers\\superchairController@showingConferenceStatistics')->middleware(['auth', 'verified'])->name('statistics.show');


//showing conference all papers
Route::get('conferencePapers/{id}', 'App\\Http\\Controllers\\superchairController@showingConferencePapers')->middleware(['auth', 'verified'])->name('conferencePapers.show');

//showing all conference Tracks
Route::get('conferenceTracks/{id}', 'App\\Http\\Controllers\\superchairController@showingConferenceTracks')->middleware(['auth', 'verified'])->name('conferenceTracks.show');


//showing SuperChair conference data
Route::get('conferenceData/{id}', 'App\\Http\\Controllers\\superchairController@conferenceData')->middleware(['auth', 'verified'])->name('conference.Data');

//showing status of pages in conference
Route::get('statusOfSubmissions/{id}', 'App\\Http\\Controllers\\superchairController@statusOfSubmissions')->middleware(['auth', 'verified'])->name('statusOfSubmissions');


//showing single trackchair data
Route::post('showingTrackchairData/{id}', 'App\\Http\\Controllers\\superchairController@showingTrackchairData')->middleware(['auth', 'verified'])->name('showingTrackchairData');

//adding track into a conference
Route::get('creatingTrack/{id}','App\\Http\\Controllers\\superchairController@creatingtrack')->middleware(['auth', 'verified'])->name('track.create');

//storing track data
Route::post('creatingTrack/{id}', 'App\\Http\\Controllers\\superchairController@storingtrackData')->middleware(['auth', 'verified'])->name('track.add');

//showing paper Data
Route::get('paperData/{id}', 'App\\Http\\Controllers\\superchairController@paperDataPage')->middleware(['auth', 'verified'])->name('paperData.superchair');

//showing all Subreviewers
Route::get('displayingAllSubreviewers/{id}', 'App\\Http\\Controllers\\superchairController@displayingAllSubreviewers')->middleware(['auth', 'verified'])->name('displayingAllSubreviewers');

//Showing page for creating pool of subreviewer
Route::get('createMultipleSubreviewers/{id}', 'App\\Http\\Controllers\\superchairController@createMultipleSubreviewers')->middleware(['auth', 'verified'])->name('createMultipleSubreviewers');

//Showing page for creating pool of subreviewer
Route::get('displayMissingReviews/{id}', 'App\\Http\\Controllers\\superchairController@displayMissingReviews')->middleware(['auth', 'verified'])->name('displayMissingReviews');

//Showing page for all reviews in super
Route::get('displayAllReviews/{id}', 'App\\Http\\Controllers\\superchairController@displayAllReviews')->middleware(['auth', 'verified'])->name('displayAllReviews');

//Sending reviews to authors
Route::get('sendingReviewsToAuthors/{id}', 'App\\Http\\Controllers\\superchairController@sendingReviewsToAuthors')->middleware(['auth', 'verified'])->name('sendingReviewsToAuthors');

//displaying all pc members in superchair
Route::get('displayingAllPCMembers/{id}', 'App\\Http\\Controllers\\superchairController@displayingAllPCMembers')->middleware(['auth', 'verified'])->name('displayingAllPCMembers');

//displaying all submissions in superchair
Route::get('displayingAllSubmissions/{id}', 'App\\Http\\Controllers\\superchairController@displayingAllSubmissions')->middleware(['auth', 'verified'])->name('displayingAllSubmissions');

//assingning paper to PC by superchair
Route::get('assigningPaperToPCMember/{id}', 'App\\Http\\Controllers\\superchairController@assigningPaperToPCMember')->middleware(['auth', 'verified'])->name('assigningPaperToPCMember');

//showing all superchairs
Route::get('conferenceSuperchairs/{id}', 'App\\Http\\Controllers\\superchairController@conferenceSuperchairs')->middleware(['auth', 'verified'])->name('conferenceSuperchairs');

//showing all Trackchairs
Route::get('conferenceTrackchairs/{id}', 'App\\Http\\Controllers\\superchairController@conferenceTrackchairs')->middleware(['auth', 'verified'])->name('conferenceTrackchairs');

//assingning paper to PC by superchair
Route::get('downloadingZip/{id}', 'App\\Http\\Controllers\\superchairController@downloadZip')->middleware(['auth', 'verified'])->name('downloadZip');

//downloading Excel
Route::get('downloadingExcel/{id}', 'App\\Http\\Controllers\\superchairController@downloadingExcel')->middleware(['auth', 'verified'])->name('downloadingExcel');


//assingning paper to PC by superchair
Route::get('deleteRole/{id}/{role}', 'App\\Http\\Controllers\\superchairController@deleteRole')->middleware(['auth', 'verified'])->name('deleteRole');


//superchair creating pool of subreviewers
Route::post('createMultipleSubreviewers/{id}', 'App\\Http\\Controllers\\superchairController@creatingPoolOfSubreviewers')->middleware(['auth', 'verified'])->name('createMultipleSubreviewers.create');

//Showing page for all reviews in super
Route::get('showingReviewers/{id}', 'App\\Http\\Controllers\\superchairController@showingAllReviewers')->middleware(['auth', 'verified'])->name('Reviewers.show');

//showing trackchair data
Route::get('AddingTrackChair/{id}', 'App\\Http\\Controllers\\superchairController@showingTrackChairPage')->middleware(['auth', 'verified'])->name('trackchair.show');

//adding PC member without invitiation Page
Route::get('addingPCMemberWithoutInivitationPage/{id}', 'App\\Http\\Controllers\\superchairController@addingPCMemberWithoutInivitationPage')->middleware(['auth', 'verified'])->name('addingPCMemberWithoutInivitationPage');

//adding PC member without invitiation shwoing PC member data
Route::post('ShowingDataOfPCMember/{id}', 'App\\Http\\Controllers\\superchairController@ShowingDataOfPCMember')->middleware(['auth', 'verified'])->name('ShowingDataOfPCMember');

//adding PC member without invitiation
Route::post('addingPCMemberWithoutInvitation/{id}', 'App\\Http\\Controllers\\superchairController@addingPCMemberWithoutInvitation')->middleware(['auth', 'verified'])->name('addingPCMemberWithoutInvitation');


//inviting PC member by superchair
Route::get('invitingPCMember/{id}', 'App\\Http\\Controllers\\superchairController@invitingPCMember')->middleware(['auth', 'verified'])->name('invitingPCMember');

//displaying reviewer data in superchair
Route::post('displayPCmemberData/{id}', 'App\\Http\\Controllers\\superchairController@displayPCmemberData')->middleware(['auth', 'verified'])->name('displayPCmemberData');

//sending request to PC member
Route::post('sendingRequestToReviewer/{id}', 'App\\Http\\Controllers\\superchairController@sendingRequestToReviewer')->middleware(['auth', 'verified'])->name('sendingRequestToReviewer');


//assigning trackchair data
Route::post('AddingTrackChair/{id}', 'App\\Http\\Controllers\\superchairController@assigningTrackChair')->middleware(['auth', 'verified'])->name('trackchair.assign');

//deleting track 
Route::get('deletingTrack/{id}', 'App\\Http\\Controllers\\superchairController@deleteTrack')->middleware(['auth', 'verified'])->name('track.delete');

//edit paper decision
Route::post('editPaperDecision/{id}', 'App\\Http\\Controllers\\superchairController@editPaperDecision')->middleware(['auth', 'verified'])->name('editPaperDecision.superchair');

//giving access to tackchair
Route::post('givingAccessingTrackchair/{id}','App\\Http\\Controllers\\superchairController@givingAccessingTrackchair')->middleware(['auth', 'verified'])->name('givingAccessingTrackchair');

//removing assigned reviewer
Route::get('removingReviewer/{paperId}/{reviewerId}', 'App\\Http\\Controllers\\superchairController@removingReviewer')->middleware(['auth', 'verified'])->name('removingReviewer');

//Check review page in reviewer
Route::get('checkingreviewsPage/{id}', 'App\\Http\\Controllers\\trackChairController@checkingreviewsPage')->middleware(['auth', 'verified'])->name('checkreviewsPage.Trackchair');

//Check review page in reviewer
Route::get('showingstatusOfSubmissions/{id}', 'App\\Http\\Controllers\\trackChairController@showingstatusOfSubmissions')->middleware(['auth', 'verified'])->name('showingstatusOfSubmissions');


//trackChair DashBoard
Route::get('trackchairDashboard/{id}','App\\Http\\Controllers\\trackChairController@dashBoard')->middleware(['auth', 'verified'])->name('TrackChairDashboard');


//displaying trackchair conference
Route::get('showingTrackchairConference/{id}','App\\Http\\Controllers\\trackChairController@showingConference')->middleware(['auth', 'verified'])->name('showingTrackchairConference');

//adding reviewer without invitiation Page
Route::get('addingReviewerWithoutInvitiationPage/{id}','App\\Http\\Controllers\\trackChairController@addingReviewerWithoutInvitiationPage')->middleware(['auth', 'verified'])->name('addingReviewerWithoutInvitiationPage');

//adding reviewer without invitiation ( showing data of reviewer )
Route::post('addingReviewerWithoutInvitiation/{id}','App\\Http\\Controllers\\trackChairController@addingReviewerWithoutInvitiation')->middleware(['auth', 'verified'])->name('addingReviewerWithoutInvitiation');

//adding reviewer without invitiation
Route::post('addReviewer/{id}','App\\Http\\Controllers\\trackChairController@addReviewer')->middleware(['auth', 'verified'])->name('addReviewer');

//showing all submissions
Route::get('allTrackSubmissions/{id}','App\\Http\\Controllers\\trackChairController@allSubmissions')->middleware(['auth', 'verified'])->name('allTrackSubmissions');

//showing all submissions
Route::get('creatingPoolOfSubreviewersPage/{id}','App\\Http\\Controllers\\trackChairController@creatingPoolOfSubreviewersPage')->middleware(['auth', 'verified'])->name('creatingPoolOfSubreviewersPage');

//showing all submissions
Route::post('creatingPoolOfSubreviewers/{id}','App\\Http\\Controllers\\trackChairController@creatingPoolOfSubreviewers')->middleware(['auth', 'verified'])->name('creatingPoolOfSubreviewers');

//showing all subreviewers
Route::get('allSubReviewerPage/{id}','App\\Http\\Controllers\\trackChairController@allSubReviewerPage')->middleware(['auth', 'verified'])->name('allSubReviewerPage.trackchair');

//showing all reviews
Route::get('showingallReviewPage/{id}','App\\Http\\Controllers\\trackChairController@showingallReviewPage')->middleware(['auth', 'verified'])->name('showingallReviewPage.trackchair');

//showing all missing reviews
Route::get('showingAllMissingReviewPage/{id}','App\\Http\\Controllers\\trackChairController@showingAllMissingReviewPage')->middleware(['auth', 'verified'])->name('showingAllMissingReviewPage.trackchair');



//showing all reviewers
Route::get('showingAllReviewers/{id}','App\\Http\\Controllers\\trackChairController@showingAllReviewers')->middleware(['auth', 'verified'])->name('showingAllReviewers');

//showing all reviewers
Route::get('notifyingReviewerPage/{id}','App\\Http\\Controllers\\trackChairController@notifyingReviewerPage')->middleware(['auth', 'verified'])->name('notifyingReviewerPage');

//emailing all PC members
Route::post('notifyingReviewers/{id}','App\\Http\\Controllers\\trackChairController@notifyingReviewers')->middleware(['auth', 'verified'])->name('notifyingReviewers');


//editing track reviewer configuration
Route::post('editreviewerConfiguration/{id}','App\\Http\\Controllers\\trackChairController@editrerviewsconfiguration')->middleware(['auth', 'verified'])->name('editreviewerConfiguration.trackchair');


//Adding review
Route::get('addingReviewer/{id}','App\\Http\\Controllers\\trackChairController@addingReviewer')->middleware(['auth', 'verified'])->name('addingReviewer');

//Requesting reviewer
Route::post('addingReviewer/{id}','App\\Http\\Controllers\\trackChairController@sendRequest')->middleware(['auth', 'verified'])->name('requestingReviewer');

//displaying all reviewers
Route::get('allReviewers/{id}','App\\Http\\Controllers\\trackChairController@displayReviewers')->middleware(['auth', 'verified'])->name('allReviewers');

//displaying all reviewers
Route::get('paperDataPage/{id}','App\\Http\\Controllers\\trackChairController@paperDataPage')->middleware(['auth', 'verified'])->name('paperDataPage.trackchair');


//showing single reviewer data
Route::post('showingReviewerData/{id}', 'App\\Http\\Controllers\\trackChairController@showingReviewerData')->middleware(['auth', 'verified'])->name('showingReviewerData');


//Reviewer DashBoard
Route::get('reviewerDashboard/{id}','App\\Http\\Controllers\\ReviewerController@dashBoard')->middleware(['auth', 'verified'])->name('ReviewerDashboard');

//Rejecting Reviewer offer
Route::get('rejectOffer/{id}','App\\Http\\Controllers\\ReviewerController@rejectOffer')->middleware(['auth', 'verified'])->name('rejectOffer');

//Accepting Reviewer offer
Route::get('acceptOffer/{id}','App\\Http\\Controllers\\ReviewerController@acceptOffer')->middleware(['auth', 'verified'])->name('acceptOffer');

//assigning reviewer to paper
Route::get('assigningPaper/{trackId}/{userId}', 'App\\Http\\Controllers\\trackChairController@assigningPaper')->middleware(['auth', 'verified'])->name('assigningPaper');

//assigning reviewer to paper
Route::post('assigningPaper/{userId}', 'App\\Http\\Controllers\\trackChairController@assigning')->middleware(['auth', 'verified'])->name('assigning');

//showing assigned paper
Route::get('assignedPaper/{id}', 'App\\Http\\Controllers\\ReviewerController@assignedPaper')->middleware(['auth', 'verified'])->name('assigniedPaper');

//showing assigned paper
Route::get('statusSubmissions/{id}', 'App\\Http\\Controllers\\ReviewerController@statusSubmissions')->middleware(['auth', 'verified'])->name('statusSubmissions');


//displaying all papers to trackchair
Route::get('allpapers/{id}','App\\Http\\Controllers\\trackChairController@displayPapers')->middleware(['auth', 'verified'])->name('allpapers');


//assigning paper to reviewer
Route::get('assigningReviewer/{id}', 'App\\Http\\Controllers\\trackChairController@assigningReviewer')->middleware(['auth', 'verified'])->name('assigningReviewer');

//assigning reviewer to paper
Route::post('assigningReviewer/{id}', 'App\\Http\\Controllers\\trackChairController@ReviewerAssigning')->middleware(['auth', 'verified'])->name('ReviewerAssigning');


//reviewer reviewing page
Route::get('reviewingPage/{id}', 'App\\Http\\Controllers\\ReviewerController@reviewingPaperPage')->middleware(['auth', 'verified'])->name('reviewingPaperPage');

//storing reviewing data
Route::post('reviewingPage/{id}', 'App\\Http\\Controllers\\ReviewerController@reviewingPaper')->middleware(['auth', 'verified'])->name('review');

//Check review page in reviewer
Route::get('checkreviewsPage/{id}', 'App\\Http\\Controllers\\ReviewerController@checkreviewsPage')->middleware(['auth', 'verified'])->name('checkreviewsPage.Reviewer');

//edit review in review page
Route::get('editreviewPage/{id}', 'App\\Http\\Controllers\\ReviewerController@editreviewPage')->middleware(['auth', 'verified'])->name('editreviewPage.Reviewer');

//conference Data
Route::get('reviewerConferenceData/{id}', 'App\\Http\\Controllers\\ReviewerController@conferenceData')->middleware(['auth', 'verified'])->name('reviewerConferenceData');


//edit review in reviewer
Route::post('editreview/{id}', 'App\\Http\\Controllers\\ReviewerController@editreview')->middleware(['auth', 'verified'])->name('editreview.Reviewer');

//delete review in reviewer
Route::get('deletereview/{id}', 'App\\Http\\Controllers\\ReviewerController@deletereview')->middleware(['auth', 'verified'])->name('deletereview.Reviewer');

//request subreviewer
Route::get('requestsubreviewerPage/{id}', 'App\\Http\\Controllers\\ReviewerController@requestsubreviewerPage')->middleware(['auth', 'verified'])->name('requestsubreviewerPage');

//showing all subreviewers
Route::get('allSubReviewer/{id}', 'App\\Http\\Controllers\\ReviewerController@allSubReviewer')->middleware(['auth', 'verified'])->name('allSubReviewers');


//reviewer request page 
Route::get('requestBoard/{id}', 'App\\Http\\Controllers\\ReviewerController@requestBoardPage')->middleware(['auth', 'verified'])->name('requestBoard');

//creating sub reviewer
Route::get('createSubReviewer/{id}', 'App\\Http\\Controllers\\ReviewerController@createSubReviewer')->middleware(['auth', 'verified'])->name('createSubReviewer');

//showing all assigned papers
Route::get('showingAllAssignedPapers/{id}','App\\Http\\Controllers\\ReviewerController@showingAllAssignedPapers')->middleware(['auth', 'verified'])->name('showingAllAssignedPapers');


//assigning paper to subreviewer
Route::get('assignPaper/{id}','App\\Http\\Controllers\\ReviewerController@showingassignedPaper')->middleware(['auth', 'verified'])->name('showingassignedPaper');

//assigning paper to subreviewer
Route::post('assignPaper/{id}','App\\Http\\Controllers\\ReviewerController@assigningPaper')->middleware(['auth', 'verified'])->name('assigningPaper.subreviewer');


//showing sub reviewer data
Route::post('createSubReviewer/{id}', 'App\\Http\\Controllers\\ReviewerController@showSubReviewer')->middleware(['auth', 'verified'])->name('showSubReviewer');

//requesting sub reviewer data
Route::post('requestSubReviewer/{id}', 'App\\Http\\Controllers\\ReviewerController@requestSubReviewer')->middleware(['auth', 'verified'])->name('requestSubReviewer');


//subreviewer request page
Route::get('subreviewerrequestBoard/{id}', 'App\\Http\\Controllers\\SubReviewerController@requestBoardPage')->middleware(['auth', 'verified'])->name('subreviewerRequestBoard');

//subreviewer Dashboard
Route::get('subReviewerDashboardBoard/{id}', 'App\\Http\\Controllers\\SubReviewerController@dashBoard')->middleware(['auth', 'verified'])->name('subReviewerDashboardBoard');

//conference Data
Route::get('subreviewerConferenceData/{id}', 'App\\Http\\Controllers\\SubReviewerController@conferenceData')->middleware(['auth', 'verified'])->name('subreviewerConferenceData');

//Rejecting SubReviewer offer
Route::get('subreviewerrejectOffer/{id}','App\\Http\\Controllers\\SubReviewerController@rejectOffer')->middleware(['auth', 'verified'])->name('subreviewerrejectOffer');

//Accepting SubReviewer offer
Route::get('subrevieweracceptOffer/{id}','App\\Http\\Controllers\\SubReviewerController@acceptOffer')->middleware(['auth', 'verified'])->name('subrevieweracceptOffer');

//showing all submissions to subreviewer
Route::get('showingAllSubmissions/{id}','App\\Http\\Controllers\\SubReviewerController@showingAllSubmissions')->middleware(['auth', 'verified'])->name('showingAllSubmissions');


//showing assigned paper
Route::get('subReviewerAssignedPaper/{id}', 'App\\Http\\Controllers\\SubReviewerController@assignedPaper')->middleware(['auth', 'verified'])->name('subreviewerAssigniedPaper');


//subreviewing form
Route::get('subreviewerreviewingPage/{id}', 'App\\Http\\Controllers\\SubReviewerController@reviewingPaperPage')->middleware(['auth', 'verified'])->name('subreviewerreviewingPaperPage');

//storing subreviewing form data
Route::post('subreviewerreviewingPage/{id}', 'App\\Http\\Controllers\\SubReviewerController@reviewingPaper')->middleware(['auth', 'verified'])->name('subreviewerreview');

//Check review page in subreviewer
Route::get('subreviewerCheckReviewsPage/{id}', 'App\\Http\\Controllers\\SubReviewerController@checkreviewsPage')->middleware(['auth', 'verified'])->name('checkreviewsPage.Subreviewer');

//edit review in subreviewer page
Route::get('subreviewereditreviewPage/{id}', 'App\\Http\\Controllers\\SubReviewerController@editreviewPage')->middleware(['auth', 'verified'])->name('editreviewPage.Subreviewer');

//edit review in subreviewer
Route::post('subreviewereditreview/{id}', 'App\\Http\\Controllers\\SubReviewerController@editreview')->middleware(['auth', 'verified'])->name('editreview.Subreviewer');
