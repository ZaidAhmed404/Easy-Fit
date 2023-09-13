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

    <title>Choose Plan</title>

   
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
                
                <div class="sidebar-brand-text mx-3">Dashboard</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route ('home') }}">
                    <span>Dashboard</span></a>
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
                  
                    <span>EasyFit</span>
                </a>
                <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">EasyFit Components:</h6>
                        <a class="collapse-item" href="{{ route ('about') }}">About</a>
                        <a class="collapse-item active" >Create Conference</a>
                    
                        <a class="collapse-item" href="{{ route ('makesubmission') }}">Make submission</a>
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
                                    src="{{URL('dashboard/img/undraw_profile.svg')}}">
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
                    <h1 class="h3 mb-2 text-gray-800">Choose Plan</h1>
                    
                    <div class="card shadow mb-4">
                        
                        <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
                        <div class="col">
                            <div class="card mb-4 rounded-3 shadow-sm">
                            <div class="card-header py-3">
                                <h4 class="my-0 fw-normal">Demo</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">$0<small class="text-muted fw-light">/Submissions</small></h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                <li>1 Track Allowed</li>
                                <li>20 PC members/Reviewers Allowed</li>
                                <li>20 Submissions</li>
                                <li>NO Email Notification</li>
                                </ul>
                                <a class="w-100 btn btn-lg btn-outline-primary" href="{{ route ('conference.create',['plan'=>'Demo']) }}">Sign up for free</a>
                            </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card mb-4 rounded-3 shadow-sm">
                            <div class="card-header py-3">
                                <h4 class="my-0 fw-normal">Pro</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">$1.5<small class="text-muted fw-light">/Submissions</small></h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                <li>5 Track Allowed</li>
                                <li>60 PC members/Reviewers Allowed</li>
                                <li>60 Submissions</li>
                                <li>Email Notification</li>
                                </ul>
                                <a class="w-100 btn btn-lg btn-primary" href="{{ route ('conference.create',['plan'=>'Pro']) }}">Get started</a>
                            </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card mb-4 rounded-3 shadow-sm border-primary">
                            <div class="card-header py-3 text-white bg-primary border-primary">
                                <h4 class="my-0 fw-normal">Custom</h4>
                            </div>
                            <div class="card-body">
                                <h1 class="card-title pricing-card-title">$2<small class="text-muted fw-light">/Submissions</small></h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                <li>Unlimited Track Allowed</li>
                                <li>Unlimited PC members/Reviewers Allowed</li>
                                <li>Unlimited Submissions</li>
                                <li>Email Notification</li>
                                </ul>
                                
                                <a class="w-100 btn btn-lg btn-primary" href="{{ route ('conference.create',['plan'=>'Custom']) }}">Contact us</a>
                            
                            </div>
                            </div>
                        </div>
                        </div>

                        </div>
                    </div>

                    <h1 class="h3 mb-2 text-gray-800">Compare plans</h1>
                    
                    <div class="card shadow mb-4">
                        
                        <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="width: 34%;">Activity</th>
                                <th style="width: 22%;">Free</th>
                                <th style="width: 22%;">Pro</th>
                                <th style="width: 22%;">Custom</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row" class="text-start">Number of Submissions</th>
                                <td>20</td>
                                <td>60</td>
                                <td>Unlimited</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-start">Number of PC Members/Reviewer</th>
                                <td>20</td>
                                <td>60</td>
                                <td>Unlimited</td>
                            </tr>
                            </tbody>
                            <tbody>
                            <tr>
                                <th scope="row" class="text-start">Number of Tracks</th>
                                <td>1</td>
                                <td>6</td>
                                <td>Unlimited</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-start">Email Notifications</th>
                                <td>NO</td>
                                <td>YES</td>
                                <td>YES</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-start">More Configurations</th>
                                <td>NO</td>
                                <td>YES</td>
                                <td>YES</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-start">Extra security</th>
                                <td>NO</td>
                                <td>YES</td>
                                <td>YES</td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                        </div>
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