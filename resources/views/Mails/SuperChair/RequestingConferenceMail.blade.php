<!DOCTYPE html>
<html lang="en">
<head>

    <title>Requesting Conference</title>
    <style>
        
        #box{
    border-radius: 15px;
    
    background-color: white;
            margin:10px;
            padding-left: 5%;
            padding-right: 5%;
            padding-top: 5%;
            padding-bottom: 5%;
            
            text-align:left;
        } 
    </style>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body> 
<center>
        <div id="box">

        

  <div class="p-5 text-center bg-light">
    <h1 class="mb-3">Conference Request</h1>
<hr class="solid">
<br>
Conference named {{$conference}} having {{$acronym}} is requested by {{$firstName}} {{$lastName}} , email < <strong>{{$Email}}</strong> > <br>
Conference Name : {{$conference}} <br>
Conference Acronym : {{$acronym}} <br>
SuperChair Name : {{$firstName}} {{$lastName}} <br>
SuperChair Email : {{$Email}} <br>
<br>
<hr class="solid">
<?php $hashids = new Hashids\Hashids('',40); $id=$hashids->encode($conferenceId); ?>
                
To approve Conference <a href="http://127.0.0.1:8000/approvingConference/{{$id}}">Click</a> here
  </div>
</div>
    </center>
    
</body>
</html>
