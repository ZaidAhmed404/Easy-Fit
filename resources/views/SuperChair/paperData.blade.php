<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Superchair Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


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
                                 
                <a class="nav-link" href="{{ route ('statusOfSubmissions' , $id) }}">
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
                <div id="collapse3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Components:</h6>
                        <a class="collapse-item" href="{{ route ('conference.Data', $id) }}">Configure</a>

                        <a class="collapse-item" href="{{ route ('conferenceTracks.show' , $id) }}">Tracks</a>
                      
                        <a class="collapse-item" href="{{ route ('statistics.show', $id) }}">Statistics</a>
                      
                        <a class="collapse-item" href="{{URL::to('addingSuperchair', $id)}}">Add new Superchair</a>
                      
                        <a class="collapse-item" href="{{URL::to('conferenceSuperchairs', $id)}}">All Superchairs</a>
                      
                      <a class="collapse-item" href="{{URL::to('conferenceTrackchairs', $id)}}">All Trackchairs</a> </div>
                </div>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider">
  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse4"
                    aria-expanded="true" aria-controls="collapse3">
                  
                    <span>Other</span>
                </a>
                <div id="collapse4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Components:</h6>
                        <a class="collapse-item" href="{{ route ('downloadZip', $id) }}">Download Papers</a>
                        <a class="collapse-item" href="{{ route ('downloadingExcel', $id) }}">Download Excel</a>
                    
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
                    <h1 class="h3 mb-2 text-gray-800">Paper, Author, Reviewers and Review</h1>
                

                <!-- /.container-fluid -->


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Paper</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <tr>
                                  <td>Title</td>  
                                  <td>{{$Paper->Title}}</td>
                                  </tr>
                                  <tr>
                                    <td>Track</td>
                                    <td>{{$Track->Name}}</td>
                                  </tr>
                                  <tr>
                                  <td>Keywords</td>
                                  <td>{{$Paper->tags}}</td>
                                </tr>

                                  <tr>
                                    <td>Abstract</td>
                                    <td>{{$Paper->Abstract}}</td>
                                  </tr>
                                  <tr>
                                    <td>Current Decision</td>
                                    
                                    <td>
                                      {{$Paper->decision}}
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      Re-upload Paper
                                    </td>
                                    <td>
                                    <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    Re-submit
                                  </a>
                                  <div class="collapse" id="collapseExample">
                                    
                                  <?php $hashids = new Hashids\Hashids('',40); $paperId=$hashids->encode($Paper->id); ?>
                                    
                                <form action="{{ route ('File.upload', $paperId) }}" enctype="multipart/form-data" method="post">
                                        @csrf
                                <center><br>
                                    <input name="file" id="file" type="file" required><br><br>
                                        <center>
                                        <input accept=".pdf" class="btn btn-primary" type="submit" value="Submit">
                                    
                                        </center>
                                    </form>  
                                </div>

                                    </td>
                                  </tr>

                                  <tr>
                                    <td>Decide</td>
                                    <td>
                                      
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                  Decide
                                </button>

                                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Select decision</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                      <form action="{{ route ('editPaperDecision.superchair', $paperId) }}" method="post">
                                        @csrf

                                  <br>
                                  <div class="form-check">
                                              <input class="form-check-input" type="radio" value="Strong Accept" name="decision" id="decision">
                                              <label class="form-check-label" >
                                              Strong Accept
                                              </label><br><br>
                                              </div>
                                          
                                  <div class="form-check">
                                              <input class="form-check-input" type="radio" value="Weak Accept" name="decision" id="decision">
                                              <label class="form-check-label" >
                                              Weak Accept
                                              </label><br><br>
                                              </div>
                                              <div class="form-check">
                                              <input class="form-check-input" type="radio" value="Normal" name="decision" id="decision">
                                              <label class="form-check-label" >
                                              Normal
                                              </label><br><br>
                                              </div>
                                        

                                  <div class="form-check">
                                              <input class="form-check-input" type="radio" value="Weak Reject" name="decision" id="decision">
                                              <label class="form-check-label" >
                                              Weak Reject
                                              </label><br><br>
                                              </div>
                                        
                                              
                                  <div class="form-check">
                                              <input class="form-check-input" type="radio" value="Strong Reject" name="decision" id="decision">
                                              <label class="form-check-label" >
                                              Strong Reject
                                              </label><br><br>
                                              </div>
                                            
                                  </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <input class="btn btn-primary" type="submit" value="Decide">
                                      </div>
                                        
                                        
                                    
                                        
                                    </form> 

                                    
                                    </div>
                                  </div>
                                    </td>
                                  </tr>

                                  <tr>
                                    <td>Action</td>
                                  <td> <a class="btn btn-primary" href="{{ route ('File.downloading' ,$paperId) }}">Download Paper</a>
                                        </td>
                                  </tr>

                                </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Authors</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                  <tr>
                                    
                                  <th>First Name</th>
                                  <th>Last Name</th>
                                  <th>Country</th>
                                  <th>Email</th>
                                  <th>Organization</th>
                                  <th>Web</th>
                                  <th>Correcponding Authors</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <p id="forDeleteCode"></p>
                                    

                                  @foreach ($authors as $author)
                                    @php $index=0; @endphp
                                  <tr> 
                                  <td>{{$author->user->firstName}} </td>
                                  <td>{{$author->user->lastName}}</td>
                                  <td>{{$author->user->country}}</td>
                                  <td>{{$author->user->email}}</td>
                                  <td>{{$author->user->organization}}</td>
                                  <td>{{$author->user->web}}</td>
                                  <td>{{$author->correcpondindauthor}}</td>
                                  </tr>
                                  @php $index++; @endphp
                                  @endforeach

                                  </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Reviewers</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                  <tr>
                                    
                                  <th>First Name</th>
                                  <th>Last Name</th>
                                  <th>Country</th>
                                  <th>Email</th>
                                  <th>Organization</th>
                                  <th>Web</th>
                                  <th>Action</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <p id="forDeleteCode"></p>
                                    

                                  @foreach ($reviewers as $reviewer)

                                  <tr> 
                                  <td>{{$reviewer->user->firstName}} </td>
                                  <td>{{$reviewer->user->lastName}}</td>
                                  <td>{{$reviewer->user->country}}</td>
                                  <td>{{$reviewer->user->email}}</td>
                                  <td>{{$reviewer->user->organization}}</td>
                                  <td>{{$reviewer->user->web}}</td>
                                  <?php $hashids = new Hashids\Hashids('',40); $reviewerId=$hashids->encode($reviewer->id); ?>
                                    
                                  <td><a class="btn btn-danger" href="{{ route('removingReviewer' , ['paperId'=>$paperId,'reviewerId'=>$reviewerId]) }}">Remove</a>
                                  </td>
                                  </tr>

                                  @endforeach

                                  </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Review</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                  <tr>
                                  <th>For Author</th>
                                  <th>For PC member</th>
                                  <th>Confident</th>
                                  <th>Evaluation</th>
                                  <th>Action</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <p id="forDeleteCode"></p>
                                    
                                  @foreach ($reviews as $review)

                                  <tr> 
                                  <td>{{$review->review}} </td>
                                  <td>{{$review->reviewForReviewers}}</td>

                                  <td>{{$review->confident}}</td>

                                  <td>{{$review->evaluation}}</td>
                                  <?php $hashids = new Hashids\Hashids('',40); $reviewId=$hashids->encode($review->id); ?>
                                   
                                  <td><a class="btn btn-danger" href="{{ route('deletereview.Reviewer' , $reviewId) }}">Delete</a>
                                  </td>
                                  </tr>

                                  @endforeach

                                  </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

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