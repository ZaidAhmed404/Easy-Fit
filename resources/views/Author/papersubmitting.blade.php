<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>EasyFit</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js" integrity="sha512-VvWznBcyBJK71YKEKDMpZ0pCVxjNuKwApp4zLF3ul+CiflQi6aIJR+aZCP/qWsoFBA28avL5T5HA+RE+zrGQYg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput-angular.min.js" integrity="sha512-KT0oYlhnDf0XQfjuCS/QIw4sjTHdkefv8rOJY5HHdNEZ6AmOh1DW/ZdSqpipe+2AEXym5D0khNu95Mtmw9VNKg==" crossorigin="anonymous"></script>
    <style type="text/css">
        .bootstrap-tagsinput{
            width: 100%;
        }
        .label-info{
            background-color: #17a2b8;

        }
        .label {
            display: inline-block;
            padding: 5px;
            margin:5px;
            line-height: 1;
        }
        
        .star{
color:red;
}
 
    </style>
    
        
      

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
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">EasyFit Components:</h6>
                        <a class="collapse-item" href="{{ route ('about') }}">About</a>
                        <a class="collapse-item" href="{{ route ('selectingPlan') }}">Create Conference</a>
                    
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
                    <h1 class="h3 mb-2 text-gray-800">Author Information</h1>
                    For each author please fill out the form below. Some items on the form are explained here:
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
                            <h6 class="m-0 font-weight-bold text-primary">Add Author Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <?php $hashids = new Hashids\Hashids('',40); $ConferenceId=$hashids->encode($conferenceId); $TrackId=$hashids->encode($trackId); ?>
                                
                            <form action="{{ route('paper.submit' ,['conferenceid'=>$ConferenceId,'trackid'=>$TrackId]) }}" enctype="multipart/form-data" method="post">
                              @csrf
                        <table class="table table-bordered" id="dynamicTable">  
                                  <tr>
                                      <th>EasyFit Email<sup class="star">*</sup></th>
                                      @if($submissionFormConfiguration->disableMultipleAuthors=="NO")
                                      <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  
                                  
                                      @endif
                                      
                                  </tr>
                                  <tr>  
                                      <td><input type="text" name="data[0][email]" placeholder="Enter your Easyfit Email" class="form-control" required/>
                                    <br>
                                    Correcponding Author<sup class="star">*</sup>
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" value="YES" name="data[0][correcpondingAuthor]" required>
                                    <label class="form-check-label" >
                                    Yes
                                    </label>
                                    </div>
                                    <div class="form-check">
                                    <input class="form-check-input" type="radio" value="NO" name="data[0][correcpondingAuthor]" required>
                                    <label class="form-check-label" >
                                    No
                                    </label>
                                    </div>
                                    <br>
                                    @if($submissionFormConfiguration->requirePostalAddress=="YES")
                                    <div class="form-group row">
                                        <div class="col-sm-10">
                                        <input placeholder="Enter the Postal Address" class="form-control"   type="text"  name="data[0][postalAddress]" required>
                                    </div>
                                    </div>
                                    <br>
                                    @endif
                                    </td>  
                                  <td></td>
                                    </tr>  
                              </table> 
                      
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

              <!-- Begin Page Content -->
              <div class="container-fluid">

              <!-- Page Heading -->
              <h1 class="h3 mb-2 text-gray-800">Paper Form</h1>

                
              <!-- DataTales Example -->
              <div class="card shadow mb-4">
                  <div class="card-header py-3">
                      <h6 class="m-0 font-weight-bold text-primary">Add Paper Data</h6>
                  </div>
                  
                  <div class="card-body">
                      <div class="table-responsive">
                      
                      @if($submissionFormConfiguration->preSubmissionAllowed!="YES")
                      <strong>Note: Character Limit is 200</strong>
                      <br><br>
                      <div class="form-group row">
                          <label for="staticEmail" class="col-sm-2 col-form-label">Title<sup class="star">*</sup></label>
                          <div class="col-sm-10">
                          <input placeholder="Enter the Paper Title" class="form-control" maxlength="200"  type="text" id="title" name="title" required>
                              </div>
                        </div>
                      
                      @endif
                    <br>
                      @if(($submissionFormConfiguration->disableAbstract=="NO" && $submissionFormConfiguration->preSubmissionAllowed=="YES") ||($submissionFormConfiguration->disableAbstract=="NO" && $submissionFormConfiguration->preSubmissionAllowed=="NO"))
                      <strong>Note: Character Limit is 9500</strong>
                      <br><br>
                      <div class="form-group row">
                          <label for="staticEmail" class="col-sm-2 col-form-label">Abstract<sup class="star">*</sup></label>
                          <div class="col-sm-10">
                          <textarea placeholder="Enter the Paper Abstract" maxlength="9500"  class="form-control"   type="text" id="abstract" name="abstract" rows="10" cols="100" required></textarea>
                              </div>
                        </div>
                      <br>
            
                      @endif
                      
                      <br>
                      @if($submissionFormConfiguration->preSubmissionAllowed!="YES")
                      <p><strong>Note: After Entering any keyword; Press Enter key on Keyboard.</strong> </p> <br>
                              
                      <div class="form-group row">
                          <label for="staticEmail" class="col-sm-2 col-form-label">Keywords<sup class="star">*</sup></label>
                          <div class="col-sm-10">
                          <input type="text" data-role="tagsinput" name="tags" id="tags" class="form-control" required>
                        </div>
                        </div>

                      @endif
                      
                      <br>
                      <br>
                      @if($submissionFormConfiguration->preSubmissionAllowed!="YES")
                      
                      @if($submissionFormConfiguration->fileUpload=="YES")
                      <div class="form-group row">
                          <label for="staticEmail" class="col-sm-2 col-form-label">Upload Paper<sup class="star">*</sup></label>
                          <div class="col-sm-10">
                          <input name="file" id="file" type="file" required>
                              </div>
                        </div>
                      <br>
                        @endif           
                      @endif        
                              
                              <br><br>
                              <p> Note: Check Author Email for Confirmation. <strong>Do not press the button twice: uploading may take time!</strong> </p> <br>
                              <center>
                              <input accept=".pdf" class="btn btn-primary" type="submit" value="Submit">
                          
                              </center>
                              <br><br>
                          </form>  

                      </div>
                  </div>
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

    <script type="text/javascript">
      
    var i = 0;
    $("#add").click(function(){
        ++i;
        $("#dynamicTable").append('<tr><td><input type="text" name="data['+i+'][email]" placeholder="Enter your EasyFit Email" class="form-control" required/><br>Correcponding Author<sup class="star">*</sup><div class="form-check"><input class="form-check-input" type="radio" value="YES" name="data['+i+'][correcpondingAuthor]"  required><label class="form-check-label" >Yes</label></div><div class="form-check"><input class="form-check-input" type="radio" value="NO" name="data['+i+'][correcpondingAuthor]" required><label class="form-check-label" >No</label></div>@if($submissionFormConfiguration->requirePostalAddress=="YES")<div class="form-group row"><div class="col-sm-10"><input placeholder="Enter the Postal Address" class="form-control"   type="text"  name="data['+i+'][postalAddress]" required></div></div><br>@endif</td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
    });
   
    $(document).on('click', '.remove-tr', function(){  
         $(this).parents('tr').remove();
    });  
   
</script>
</body>

</html>