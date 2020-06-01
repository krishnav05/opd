@extends('layouts.master')

@section('content')

<h5 style="text-align: center;">Consultations</h5>
<center>
<ol>
  @foreach($consultations as $consult)
  @foreach($doctors as $doctor)
  @if($consult['doctorId'] == $doctor['id']) 
  <li>
    <a href="/history/{{$consult['id']}}">Checkup with {{$doctor['name']}}, {{$consult['created_at']->diffForHumans()}}</a>
  </li>
  @endif
  @endforeach
  @endforeach
</ol>  
</center>
@endsection
