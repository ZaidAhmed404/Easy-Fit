<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Superchair Dashboard</title>


<!-- Custom fonts -->
<link href="{{URL('dashboard/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles-->
    <link href="{{URL('dashboard/css/sb-admin-2.min.css')}}" rel="stylesheet">

    <!-- Custom styles -->
    <link href="{{URL('dashboard/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route ('home') }}">
                
                <div class="sidebar-brand-text mx-3">EasyFit</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
            <?php $hashids = new Hashids\Hashids('',40); $id=$hashids->encode($Conference->id); ?>
                                    
                <a class="nav-link" href="{{ route ('conference.show' , $id) }}">
                    <span>Submissions</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Components
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                  
                    <span>Review</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Review Components:</h6>
                       
                        <a class="collapse-item" href="{{ route ('conferencePapers.show', $id) }}">All Submissions</a>
          
                        <a class="collapse-item" href="{{ route ('displayingAllSubreviewers', $id) }}">Subreviewers</a>
                        
                        <a class="collapse-item" href="{{ route ('createMultipleSubreviewers', $id) }}">Pool of Subreviewers</a>
                        
                        <a class="collapse-item" href="{{ route ('displayAllReviews', $id) }}">Delete</a>
                        
                        <a class="collapse-item" href="{{ route ('sendingReviewsToAuthors', $id) }}">Send to Authorrs</a>
                        
                        <a class="collapse-item" href="{{ route ('displayMissingReviews', $id) }}">Missing reviews</a>
                      
                      </div>
                </div>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                                 
                <a class="nav-link" href="{{ route ('conferencePapers.show' , $id) }}">
                    <span>Status</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            
            
              <!-- Nav Item - Pages Collapse Menu -->
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse5"
                    aria-expanded="true" aria-controls="collapse5">
                  
                    <span>Email</span>
                </a>
                <div id="collapse5" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Email Components:</h6>
                        <a class="collapse-item" href="{{ route('notifyingPage' ,['role'=>'TRACKCHAIR','id'=>$id]) }}">All Trackchairs</a>
            
                        <a class="collapse-item" href="{{ route('notifyingPage' ,['role'=>'AUTHOR','id'=>$id]) }}">All Authors</a>
            
                        
                      </div>
                </div>
            </li>
            <hr class="sidebar-divider">
            <!-- Nav Item - Pages Collapse Menu -->
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse1"
                    aria-expanded="true" aria-controls="collapse1">
                  
                    <span>Assignment</span>
                </a>
                <div id="collapse1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Assignment Components:</h6>
                        <a class="collapse-item" href="{{ route ('displayingAllPCMembers' , $id) }}">By PC members</a>
            
                        <a class="collapse-item" href="{{ route ('displayingAllSubmissions' , $id) }}">By Submission</a>
                        
                      </div>
                </div>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider">
              <!-- Nav Item - Pages Collapse Menu -->
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse2"
                    aria-expanded="true" aria-controls="collapse2">
                  
                    <span>PC</span>
                </a>
                <div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">PC Components:</h6>
                        <a class="collapse-item" href="{{ route ('Reviewers.show' , $id) }}">View PC</a>
                        
                        <a class="collapse-item" href="{{ route ('invitingPCMember' , $id) }}">Invitiation to PC</a>
                       
                        <a class="collapse-item" href="{{ route ('addingPCMemberWithoutInivitationPage' , $id) }}">Add new PC members</a>
                        
                        <a class="collapse-item" href="{{ route('notifyingPage' ,['role'=>'REVIEWER','id'=>$id]) }}">Send Email</a>
                        
                        
                      </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
              <!-- Nav Item - Pages Collapse Menu -->
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse3"
                    aria-expanded="true" aria-controls="collapse3">
                  
                    <span>Administration</span>
                </a>
                <div id="collapse3" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Components:</h6>
                        <a class="collapse-item active" href="{{ route ('conference.Data', $id) }}">Configure</a>

                        <a class="collapse-item" href="{{ route ('conferenceTracks.show' , $id) }}">Tracks</a>
                      
                        <a class="collapse-item" href="{{ route ('statistics.show', $id) }}">Statistics</a>
                      
                        <a class="collapse-item" href="{{URL::to('addingSuperchair', $id)}}">Add new Superchair</a>
                      
                      </div>
                </div>
            </li>
            

            


            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}</span>
                                <img class="img-profile rounded-circle"
                                    src="http://127.0.0.1:8000/dashboard/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('editUserDataPage') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Edit Profile
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">{{$Conference->acronym}} Configuration</h1>
                
                <!-- /.container-fluid -->

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                Conference Data             
                            </h6>
                            <div class="float-right">
                                <a href="">Edit Conference Details</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <tr>
                                    <td>
                                        Conference name
                                    </td>
                                    <td>
                                        {{$Conference->conferenceName}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Conference Acronym
                                    </td>
                                    <td>
                                        {{$Conference->acronym}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Venue
                                    </td>
                                    <td>
                                    {{$Conference->venue}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Country
                                    </td>
                                    <td>
                                    {{$Conference->Country}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Conference Web
                                    </td>
                                    <td>
                                        <a href="{{$Conference->web}}">{{$Conference->web}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Submission link
                                    </td>
                                    <td>
                                    <?php $hashids = new Hashids\Hashids('',40); $conferenceId=$hashids->encode($Conference->id); ?>
                                    
                                    <a href="{{ route ('choose.track', $conferenceId) }}">{{ route ('choose.track', $conferenceId) }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Starting Date
                                    </td>
                                    <td>
                                    {{$Conference->startingDate}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Ending Date
                                    </td>
                                    <td>
                                    {{$Conference->endingDate}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Primary Aim
                                    </td>
                                    <td>
                                    {{$Conference->primaryAim}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Secondary Aim
                                    </td>
                                    <td>
                                    {{$Conference->secondaryAim}}
                                    </td>
                                </tr> 
                                <tr>
                                    <td>
                                        Contact Email
                                    </td>
                                    <td>
                                    {{$Conference->contactEmail}}
                                    </td>
                                </tr>   
                            </table>
                            </div>
                        </div>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Paper Configuration</h6>
                        </div>
                        <div class="card-body">
                        
                        <?php $hashids = new Hashids\Hashids('',40); $conferenceId=$hashids->encode($Conference->id); ?>
                        
                        <form action="{{ route ('editpaperConfiguration', $conferenceId) }}" method="post">
                            @csrf
                            <table class="table table-bordered table-striped">
                            <tr>
                            <td>
                                Activities
                            </td>
                            <td>
                                Change Configuration
                            </td>
                        </tr>
                        <tr>

                            <td>
                            Allow Paper Submission
                            </td>
                            <td>
                            <select class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="paperSubmission" name="paperSubmission">
                            
                            <option value="{{$paperconfiguration->paperSubmission}}">{{$paperconfiguration->paperSubmission}}</option>
                            @if($paperconfiguration->paperSubmission=="YES")
                            <option value="NO">NO</option>
                            @endif
                            @if($paperconfiguration->paperSubmission!="YES")
                            <option value="YES">YES</option>
                            @endif
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            Allow Paper Re-Submission
                            </td>
                            <td>
                            <select class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="paperReSubmission" name="paperReSubmission">
                            <option value="{{$paperconfiguration->paperReSubmission}}">{{$paperconfiguration->paperReSubmission}}</option>
                            @if($paperconfiguration->paperReSubmission=="YES")
                            <option value="NO">NO</option>
                            @endif
                            @if($paperconfiguration->paperReSubmission!="YES")
                            <option value="YES">YES</option>
                            @endif
                            </select>
                            
                            </td>
                        </tr>
                    </table>
                            <center>
                            <input class="btn btn-primary" type="submit" value="Change Paper Configuration">
                        
                            </center>
                        </form>
                        
                        
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Review Configuration</h6>
                        </div>
                        <div class="card-body">
                            
                        <form action="{{ route ('editreviewsConfiguration', $conferenceId) }}" method="post">
                            @csrf
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>
                                Activities
                            </td>
                            <td>
                                Change Configuration
                            </td>
                        </tr>
                        <tr>

                            <td>
                            Allow Reviewer to review papers
                            </td>
                            <td>
                            <select class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="allowReviews" name="allowReviews">
                            
                            <option value="{{$reviewconfiguration->allowReviews}}">{{$reviewconfiguration->allowReviews}}</option>
                            @if($reviewconfiguration->allowReviews=="YES")
                            <option value="NO">NO</option>
                            @endif
                            @if($reviewconfiguration->allowReviews!="YES")
                            <option value="YES">YES</option>
                            @endif
                            </select>
                            </td>
                        </tr>
                        
                        <tr>

                            <td>
                            Show Reviewer Names To Authors
                            </td>
                            <td>
                            <select class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="showReviewerNames" name="showReviewerNames">
                            
                            <option value="{{$reviewconfiguration->showReviewerNames}}">{{$reviewconfiguration->showReviewerNames}}</option>
                            @if($reviewconfiguration->showReviewerNames=="YES")
                            <option value="NO">NO</option>
                            @endif
                            @if($reviewconfiguration->showReviewerNames!="YES")
                            <option value="YES">YES</option>
                            @endif
                            </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                            Allow Sub-Reviewer
                            </td>
                            <td>
                            <select class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="allowSubreviews" name="allowSubreviews">
                            
                            <option value="{{$reviewconfiguration->allowSubreviews}}">{{$reviewconfiguration->allowSubreviews}}</option>
                            @if($reviewconfiguration->allowSubreviews=="YES")
                            <option value="NO">NO</option>
                            @endif
                            @if($reviewconfiguration->allowSubreviews!="YES")
                            <option value="YES">YES</option>
                            @endif
                            </select>
                            </td>
                        </tr>
                        

                        <tr>
                            <td>
                            Show Authors Names to PC Members
                            </td>
                            <td>
                            <select class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="showAuthorsNames" name="showAuthorsNames">
                            
                            <option value="{{$reviewconfiguration->showAuthorsNames}}">{{$reviewconfiguration->showAuthorsNames}}</option>
                            @if($reviewconfiguration->showAuthorsNames=="YES")
                            <option value="NO">NO</option>
                            @endif
                            @if($reviewconfiguration->showAuthorsNames!="YES")
                            <option value="YES">YES</option>
                            @endif
                            </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                            Allow Status Menu to Reviewers
                            </td>
                            <td>
                            <select class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="allowStatusMenu" name="allowStatusMenu">
                            
                            <option value="{{$reviewconfiguration->allowStatusMenu}}">{{$reviewconfiguration->allowStatusMenu}}</option>
                            @if($reviewconfiguration->allowStatusMenu=="YES")
                            <option value="NO">NO</option>
                            @endif
                            @if($reviewconfiguration->allowStatusMenu!="YES")
                            <option value="YES">YES</option>
                            @endif
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            Allow Status Menu to TrackChair
                            </td>
                            <td>
                            <select class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="allowTrackchairStatusMenu" name="allowTrackchairStatusMenu">
                            
                            <option value="{{$reviewconfiguration->allowTrackchairStatusMenu}}">{{$reviewconfiguration->allowTrackchairStatusMenu}}</option>
                            @if($reviewconfiguration->allowTrackchairStatusMenu=="YES")
                            <option value="NO">NO</option>
                            @endif
                            @if($reviewconfiguration->allowTrackchairStatusMenu!="YES")
                            <option value="YES">YES</option>
                            @endif
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            Reviews Access
                            </td>
                            <td>
                            <select class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="reviewsAccess" name="reviewsAccess">
                            
                            <option value="{{$reviewconfiguration->reviewsAccess}}">{{$reviewconfiguration->reviewsAccess}}</option>
                            @if($reviewconfiguration->reviewsAccess=="YES")
                            <option value="NO">NO</option>
                            @endif
                            @if($reviewconfiguration->reviewsAccess!="YES")
                            
                         <option value="YES">YES</option>
                            @endif
                            </select>
                            </td>
                        </tr>
                        
                        
                    </table>
                            <center>
                            <input class="btn btn-primary" type="submit" value="Change Review Configuration">
                        
                            </center>
                        </form>
    
                        </div>
                    </div>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Submission Form Configuration</h6>
                        </div>
                        <div class="card-body">
                    <form action="{{ route ('editSubmissionFormConfiguration', $conferenceId) }}" method="post">
                            @csrf
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>
                                Activities
                            </td>
                            <td>
                                Change Configuration
                            </td>
                        </tr>
                        <tr>

                            <td>
                            Do you Require Postal Address for correspondance on Submission
                            </td>
                            <td>
                            <select class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="requirePostalAddress" name="requirePostalAddress">
                            
                            <option value="{{$submissionFormConfiguration->requirePostalAddress}}">{{$submissionFormConfiguration->requirePostalAddress}}</option>
                            @if($submissionFormConfiguration->requirePostalAddress=="YES")
                            <option value="NO">NO</option>
                            @endif
                            @if($submissionFormConfiguration->requirePostalAddress!="YES")
                            <option value="YES">YES</option>
                            @endif
                            </select>
                            </td>
                        </tr>
                        
                        <tr>

                            <td>
                            Is Pre-Submission of Abstract Allowed?
                            </td>
                            <td>
                            <select class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="preSubmissionAllowed" name="preSubmissionAllowed">
                            
                            <option value="{{$submissionFormConfiguration->preSubmissionAllowed}}">{{$submissionFormConfiguration->preSubmissionAllowed}}</option>
                            @if($submissionFormConfiguration->preSubmissionAllowed=="YES")
                            <option value="NO">NO</option>
                            @endif
                            @if($submissionFormConfiguration->preSubmissionAllowed!="YES")
                            <option value="YES">YES</option>
                            @endif
                            </select>
                            </td>
                        </tr>
                        
                        <tr>

                            <td>
                            Disable Abstract Field on Submission Form?
                            </td>
                            <td>
                            <select class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="disableAbstract" name="disableAbstract">
                            
                            <option value="{{$submissionFormConfiguration->disableAbstract}}">{{$submissionFormConfiguration->disableAbstract}}</option>
                            @if($submissionFormConfiguration->disableAbstract=="YES")
                            <option value="NO">NO</option>
                            @endif
                            @if($submissionFormConfiguration->disableAbstract!="YES")
                            <option value="YES">YES</option>
                            @endif
                            </select>
                            </td>
                        </tr>

                        <tr>

                            <td>
                            Disable Multiple Authors?
                            </td>
                            <td>
                            <select class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="disableMultipleAuthors" name="disableMultipleAuthors">
                            
                            <option value="{{$submissionFormConfiguration->disableMultipleAuthors}}">{{$submissionFormConfiguration->disableMultipleAuthors}}</option>
                            @if($submissionFormConfiguration->disableMultipleAuthors=="YES")
                            <option value="NO">NO</option>
                            @endif
                            @if($submissionFormConfiguration->disableMultipleAuthors!="YES")
                            <option value="YES">YES</option>
                            @endif
                            </select>
                            </td>
                        </tr>

                        <tr>

                            <td>
                            File Upload Fields in Submission Form
                            </td>
                            <td>
                            <select class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="fileUpload" name="fileUpload">
                            
                            <option value="{{$submissionFormConfiguration->fileUpload}}">{{$submissionFormConfiguration->fileUpload}}</option>
                            @if($submissionFormConfiguration->fileUpload=="YES")
                            <option value="NO">NO</option>
                            @endif
                            @if($submissionFormConfiguration->fileUpload!="YES")
                            <option value="YES">YES</option>
                            @endif
                            </select>
                            </td>
                        </tr>

                        <tr>

                            <td>
                            Authors should select presenter?
                            </td>
                            <td>
                            <select class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="presenterSelected" name="presenterSelected">
                            
                            <option value="{{$submissionFormConfiguration->presenterSelected}}">{{$submissionFormConfiguration->presenterSelected}}</option>
                            @if($submissionFormConfiguration->presenterSelected=="YES")
                            <option value="NO">NO</option>
                            @endif
                            @if($submissionFormConfiguration->presenterSelected!="YES")
                            <option value="YES">YES</option>
                            @endif
                            </select>
                            </td>
                        </tr>
                        
                    </table>
                            <center>
                            <input class="btn btn-primary" type="submit" value="Change Submission Form Configuration">
                        
                            </center>
                        </form>
    
                        
                    



                        </div>
            </div>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; EasyFit 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    
                    <a class="btn btn-primary" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                      </a>
                    <form id="logout-form"  action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                    </form>

                  </div>
            </div>
        </div>
    </div>

    @include('sweetalert::alert')
    <!-- Bootstrap core JavaScript-->

    <script src="{{URL('dashboard/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{URL('dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{URL('dashboard/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{URL('dashboard/js/sb-admin-2.min.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{URL('dashboard/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL('dashboard/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{URL('dashboard/js/demo/datatables-demo.js')}}"></script>

</body>

</html>