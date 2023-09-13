<!DOCTYPE html>
<html lang="en">
<head>

    <title>Paper Submission</title>
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
  
    <h1 class="mb-3">Paper Submmission</h1>
    <hr class="solid">
<br>
Respected Authors, <br>
{{$users}}
<br>
We received your submission to {{$acronym}} ({{$conference}}): <br><br>
Paper Title : {{$title}} <br>
Track : {{$track}} <br><br>
The submission was uploaded by {{$authenticatedUser}} {{$lastName}} < {{$authenticatedEmail}} >  <br>
Thank you for submitting to FIT 2022. <br>
Best regards, <br>EasyFit for {{$conference}}. <br>

        <hr class="solid">
  </div>
</div>
    </center>
    
</body>
</html>
