Dear authors, <br>
Your Files has successfully been <strong>updated</strong> into your submission to {{$conference}}: <br><br>
Authors : 
@foreach ($Authors as $Author)
@if($Author->GroupID==$authenticatedId)
{{$Author->FirstName}} {{$Author->LastName}} , 
@endif
@endforeach
<br>
Title : {{$title}} <br>
Number : {{$groupId}} <br>
Track : {{$track}} 