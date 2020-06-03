@extends('layouts.master')

@section('content')

<h5 style="text-align: center;">Consultations</h5>
<center>
<ul class="patient-history">
  @foreach($consultations as $consult)
  @foreach($doctors as $doctor)
  @if($consult['doctorId'] == $doctor['id']) 
  <li>
    <a href="/history/{{$consult['id']}}">Checkup with {{$doctor['name']}}, {{$consult['created_at']->diffForHumans()}}</a>
    <i class="fa fa-arrow-right"></i>
  </li>
  @endif
  @endforeach
  @endforeach
</ul>
</center>
@endsection

@section('css')
<style type="text/css">
	.patient-history{
	                 margin: 20px;
	                 padding: 0px;
	                 list-style:none;
                }
.patient-history li{
	                   margin-bottom: 10px;
	                   background: #fff;
	                   padding: 10px;
	                   border-radius: 6px;
	                   border:1px solid #255985;
                   }
.patient-history li .fa{float: right; margin-top:5px; }
</style>
@endsection
