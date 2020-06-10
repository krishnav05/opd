@extends('layouts.master')

@section('content')

<h5 style="text-align: center;">Consultation History</h5>
<center>
<ul class="patient-history">
  @if(Auth::user()->role_id == 2)
  @foreach($consultations as $consult)
  @foreach($doctors as $doctor)
  @if($consult['doctorId'] == $doctor['id']) 
  <li>
    <a href="/history/{{$consult['id']}}">Checkup with {{$doctor['name']}}, {{$consult['created_at']->diffForHumans()}}  <i class="fa fa-chevron-right"></i></a>
    <!-- <i class="fa fa-arrow-right"></i> -->
  </li>
  @endif
  @endforeach
  @endforeach
  @else
  @foreach($consults as $consult)
  @foreach($patients as $patient)
  @if($consult['patientId'] == $patient['id']) 
  <li>
    <a href="/history/{{$consult['id']}}">Checkup with {{$patient['phone']}}, {{$consult['created_at']->diffForHumans()}}  <i class="fa fa-chevron-right"></i></a>
    <!-- <i class="fa fa-arrow-right"></i> -->
  </li>
  @endif
  @endforeach
  @endforeach
  @endif
</ul>
</center>
@endsection

@section('css')
<style type="text/css">
	.patient-history{
	                 margin: 20px;
	                 padding: 0px;
	                 list-style:none;
                   text-align: left;
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
