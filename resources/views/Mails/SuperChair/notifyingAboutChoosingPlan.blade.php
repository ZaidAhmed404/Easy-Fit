<!DOCTYPE html>
<html lang="en">
<head>

    <title>Notifying About Choosing Plan</title>
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
  
    <h1 class="mb-3">Notifying About Choosing Plan</h1>
    <hr class="solid">
<br>
Dear {{$firstName}} {{$lastName}},
<br>
this is to confirm that we received your application to use EasyFit
{{$plan}} license for {{$conference}}. The details of your application are as
follows.
<br><br>
  License: {{$plan}} <br>
  Estimated number of submissions: {{$Submissions}} <br>
  Event end date: {{$endingDate}} <br>
  Additional information: <br>
<br>
We will contact you soon. If you did not receive any reply within 24
hours.
<br>
Best regards, <br>
EasyFit license support
    <hr class="solid">
  </div>
</div>
    </center>
    
</body>
</html>
