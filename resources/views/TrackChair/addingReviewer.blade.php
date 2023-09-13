<!DOCTYPE html>
<html lang="en">

<head>

<style>
      .star{
color:red;
}
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Trackchair Dashboard</title>

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
            <?php $hashids = new Hashids\Hashids('',40); $trackId=$hashids->encode($Track->id); ?>
               
                <a class="nav-link" href="{{ route ('TrackChairDashboard' , $trackId) }}">
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
                       
                        <a class="collapse-item" href="{{ route ('allTrackSubmissions', $trackId) }}">All Submissions</a>
          
                        <a class="collapse-item" href="{{ route ('allSubReviewerPage.trackchair', $trackId) }}">Subreviewers</a>
                        
                        <a class="collapse-item" href="{{ route ('creatingPoolOfSubreviewersPage', $trackId) }}">Pool of Subreviewers</a>
                        
                        <a class="collapse-item" href="{{ route ('showingallReviewPage.trackchair', $trackId) }}">Delete</a>
                        
                        <a class="collapse-item" href="{{ route ('showingAllMissingReviewPage.trackchair', $trackId) }}">Missing reviews</a>
                      
                      </div>
                </div>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            @if($conferenceReviewerConfiguration->allowTrackchairStatusMenu=="YES")
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route ('showingstatusOfSubmissions' , $trackId) }}">
                    <span>Status</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            @endif              <!-- Nav Item - Pages Collapse Menu -->
              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse1"
                    aria-expanded="true" aria-controls="collapse1">
                  
                    <span>Assignment</span>
                </a>
                <div id="collapse1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Assignment Components:</h6>
                        <a class="collapse-item" href="{{ route ('allReviewers' , $trackId) }}">By PC members</a>
            
                        <a class="collapse-item" href="{{ route ('allpapers' , $trackId) }}">By Submission</a>
            
                        
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
                <div id="collapse2" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">PC Components:</h6>
                        <a class="collapse-item" href="{{ route ('showingAllReviewers' , $trackId) }}">View PC</a>
                        
                        <a class="collapse-item active" href="{{ route ('addingReviewer' , $trackId) }}">Invitiation to PC</a>
                       
                        <a class="collapse-item" href="{{ route ('addingReviewerWithoutInvitiationPage' , $trackId) }}">Add new PC members</a>
                        
                        <a class="collapse-item" href="{{ route ('notifyingReviewerPage' , $trackId) }}">Send Email</a>
                        
                        
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
                        <a class="collapse-item" href="{{ route ('showingTrackchairConference', $trackId) }}">Configure</a>
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
                    <h1 class="h3 mb-2 text-gray-800">Requesting Reviewer Form</h1>
                    <ul>
                      <li>
                      <strong>Email address</strong> will only be used for communication with the authors. It will not appear in public Web pages of this conference. The email address can be omitted for not corresponding authors. These authors will also have no access to the submission page.
                      </li>
                      <li>
                      <strong>Note: Emails MUST already be registered</strong>
                      </li>
                      
                  </ul>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Request Form</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <form action="{{ route ('showingReviewerData' ,$trackId) }}" method="post">
                              @csrf
                      <div class="form-group row">
                          <label for="staticEmail" class="col-sm-2 col-form-label">Easyfit Email<sup class="star">*</sup></label>
                          <div class="col-sm-8">
                          <input placeholder="Ente the Easyfit Email" class="form-control"  id="email" name="email"  type="text" required>
                              </div>
                        </div>

                              
                              <center>
                              <input class="btn btn-primary" type="submit" value="Submit">
                          
                              </center> <br>
                          </form>
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