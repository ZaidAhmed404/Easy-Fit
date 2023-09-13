<!DOCTYPE html>
<html lang="en">
<head>

    <title>Author Added</title>
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
  
    <h1 class="mb-3">Adding New Author</h1>
    <hr class="solid">
    Respected {{$firstName}} {{$lastName}}, <br><br>
You are added by {{$authorfirstName}} {{$authorlastName}} , email < {{$email}} > <br>
<br><br>
Authors : {{$authors}}
<br>
Track : {{$track}} <br>
Paper Title : {{$title}} <br><br>
Best regards,<br>
EasyFit for {{$conference}}
        <hr class="solid">
  </div>
</div>
    </center>
    
</body>
</html>
