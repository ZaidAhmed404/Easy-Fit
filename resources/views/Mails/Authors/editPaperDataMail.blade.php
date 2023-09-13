Dear {{$author}}, <br>
{{$authorName}} , email < {{$authorEmail}} > have <strong>Edited Paper Details</strong> : <br><br>
Authors : 
@foreach ($Authors as $Author)
@if($Author->GroupID==$groupId)
{{$Author->FirstName}} {{$Author->LastName}} , 
@endif
@endforeach
<br>
Title : {{$title}} <br>
Conference : {{$conference}} <br>
Track : {{$track}} 