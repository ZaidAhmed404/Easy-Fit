@auth
<!DOCTYPE html>
<html lang="en">
<head>

    <title>Displaying all Reviewers</title>
    
    <style>
        body{
            background-image: linear-gradient(to right,#F6EBE6,#AEE1F9);
        }
        #box{
    border-radius: 15px;
    background-color: white;
            box-shadow: 0 10px 10px 0 rgba(0,0,0,0.2);
            margin:10px;
            padding-left: 5%;
            padding-right: 5%;
            padding-top: 2%;
            padding-bottom: 2%;
            width: 90%;
            height:90%;
            text-align:left;
        }
    </style>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body> 
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <div class="container-fluid">
  <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="{{ route ('home') }}">Roles</a>
      </li>
      
      <a class="nav-link" href="{{ route ('TrackChairDashboard' , $Track->id) }}">TrackChair</a><br>
      
      <li class="nav-item">
        <a class="nav-link active" href="{{ route ('allReviewers' , $Track->id) }}">Reviewers</a>
      </li>
      
    </ul>
   
   
    <ul class="navbar-nav ms-auto">
    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        {{ Auth::user()->firstName }} {{ Auth::user()->lastName }}
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        
        <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
          </a>
          <form id="logout-form"  action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </div>
    </li>
    </ul>
  </div>
</nav>    
    
<center>
        <div id="box">
<h3>

<h3>Reviewers</h3>
<p style="border-top: 1px solid #bbb;"></p>
<table class="table table-bordered table-striped">
<thead>
<tr>
<th>First Name</th>
<th>Last Name</th>
<th>Country</th>
<th>Email</th>
<th>Organization</th>
<th>Web</th>
</tr>
</thead>
<tbody>
<p id="forDeleteCode"></p>
@foreach ($users as $user)
<tr>
<td>{{$user->firstName}} </td>
<td>{{$user->lastName}}</td>
<td>{{$user->country}}</td>
<td>{{$user->email}}</td>
<td>{{$user->organization}}</td>
<td>{{$user->web}}</td>
</tr>
@endforeach

</div>
    </center>
</body>
</html>
@endauth
@guest
    <h3>
    login into your account
    </h3>
@endguest