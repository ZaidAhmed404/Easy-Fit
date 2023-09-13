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

    <title>Creating Conference</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

   
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
                        <a class="collapse-item active" href="{{ route ('selectingPlan') }}">Create Conference</a>
                    
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
                    <h1 class="h3 mb-2 text-gray-800">Creating new Conference</h1>
                    
                    <div class="card shadow mb-4">
                        
                        <div class="card-body">
                           <form action="{{ route ('conference.storeData',$plan) }}"  method="post">
                                    @csrf
                                <strong>Title, acronym, and Country should use English or any other language with the Latin alphabet, even if your conference uses Chinese, Russian, Arabic etc. as the main language.</strong> 
                                <br><br>
                                    <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Conference Name<sup class="star">*</sup></label>
                                <div class="col-sm-8">
                                <input placeholder="Enter the Conference Name" class="form-control"  id="conferenceName" name="conferenceName"  type="text" required>
                                    </div>
                              </div>

                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Conference Acronym<sup class="star">*</sup></label>
                                <div class="col-sm-8">
                                <input placeholder="Enter the Conference Acronym" class="form-control"  id="acronym" name="acronym"  type="text" required>
                                    </div>
                              </div>
                              <strong>Please Provide the Conference Web because it would be used for Verification of conference Details.</strong>
                              <br><br>
                            
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Conference Web<sup class="star">*</sup></label>
                                <div class="col-sm-8">
                                <input placeholder="Enter the Web" class="form-control"  id="web" name="web"  type="text" required>
                                    </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Venue<sup class="star">*</sup></label>
                                <div class="col-sm-8">
                                
                                <input placeholder="Enter the Venue" class="form-control"  id="venue" name="venue"  type="text" required>
                                    </div>
                              </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Country/Region<sup class="star">*</sup></label>
                                <div class="col-sm-8">
                                            
                            <select class="form-select" aria-label="Default select example" name="country" id="country">
                                <option value="Pakistan">Pakistan</option>
                                <option value="China">China</option>
                                <option value="Turkey">Turkey</option>
                            </select>


                             </div>
                              </div>
                              <strong>If this is not the first time your conference is organized, you can base your estimation on the number of submissions in previous years. Otherwise, enter your best guess.</strong> <br><br>
                              @if($plan=="Demo")
                              <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Estimated Submissions<sup class="star">*</sup></label>
                                <div class="col-sm-8">
                                <input placeholder="20" value="20" class="form-control"  id="estimatedSubmissions" name="estimatedSubmissions"  type="text" readonly>
                                    </div>
                              </div>
                              @endif
                              @if($plan=="Pro")
                              <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Estimated Submissions<sup class="star">*</sup></label>
                                <div class="col-sm-8">
                                <input placeholder="60" value="60" class="form-control"  id="estimatedSubmissions" name="estimatedSubmissions"  type="text" readonly>
                                    </div>
                              </div>
                              @endif
                              @if($plan=="Custom")
                              <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Estimated Submissions<sup class="star">*</sup></label>
                                <div class="col-sm-8">
                                <input placeholder="Enter the Estimated Submissions" class="form-control"  id="estimatedSubmissions" name="estimatedSubmissions"  type="text" required>
                                    </div>
                              </div>
                              @endif
                            <strong>Enter the conference dates click for more information.The dates must be in the format mm-dd-yyyy.</strong>
                            <br><br>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Starting Date<sup class="star">*</sup></label>
                                <div class="col-sm-8">
                                <input placeholder="Enter the Starting Date" class="form-control"   type="date" id="startingDate" name="startingDate" required>
                                    </div>
                              </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Ending Date<sup class="star">*</sup></label>
                                <div class="col-sm-8">
                                
                                <input placeholder="Enter the Ending Date" class="form-control"  id="endingDate" name="endingDate"  type="date" required>
                                    </div>
                              </div>
                                   <strong>Select the main research area to which the conference belongs. If your conference fits into more than one area, choose the secondary area.</strong>
                                   <br><br> 
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Primary Aim<sup class="star">*</sup></label>
                                <div class="col-sm-8">
                                <input placeholder="Enter the Primary Aim" class="form-control"  id="primaryAim" name="primaryAim"  type="text" required>
                                    </div>
                              </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Secondary Aim<sup class="star">*</sup></label>
                                <div class="col-sm-8">
                                
                                <input placeholder="Enter the Secondary Aim" class="form-control"  id="secondaryAim" name="secondaryAim"  type="text" required>
                                    </div>
                              </div>
                              <strong>Organizer. <br>
                                Information about the organizer.
                                </strong> <br><br>
                                <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Organizer<sup class="star">*</sup></label>
                                <div class="col-sm-8">
                                
                                <input placeholder="{{ Auth::user()->firstName }} {{ Auth::user()->lastName }}" class="form-control"  id="organizer" name="organizer"  type="text" readonly>
                                    </div>
                              </div>

                              <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Organizer Web<sup class="star">*</sup></label>
                                <div class="col-sm-8">
                                
                                <input placeholder="{{ Auth::user()->web }}" class="form-control"  id="organizer" name="organizer"  type="text" readonly>
                                    </div>
                              </div>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Your Role<sup class="star">*</sup></label>
                                <div class="col-sm-8">
                                
                                <input placeholder="Superchair/Admin of Conference" class="form-control"  id="organizer" name="organizer"  type="text" readonly>
                                    </div>
                              </div>
                              <strong>This Contact Email will be used by your Conference Memebers like Trachchair,PC members or Authors in case of any queries relating Conference</strong><br><br>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Contact Email<sup class="star">*</sup></label>
                                <div class="col-sm-8">
                                
                                <input placeholder="Enter the Contact Email" class="form-control"  id="contactEmail" name="contactEmail"  type="text" required>
                                    </div>
                              </div>
                              <strong>The phone number should begin with + and include the country code.Please note that we require a valid phone number where one of the organizers can be reached.</strong><br><br>
                              <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Organizer Phone Number<sup class="star">*</sup></label>
                                <div class="col-sm-8">
                                
                                <input placeholder="Enter the Organizer Phone Number" class="form-control"  id="organizerPhoneNumber" name="organizerPhoneNumber"  type="text" required>
                                    </div>
                              </div>
                            <br><br>
                                  <center>
                            <button class="btn btn-primary" type="submit">
                            create
                            </button>

                                  </center>  
                                    <br>
                                    
                                </form> 
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