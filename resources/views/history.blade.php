@extends('layouts.master')

@section('content')

@foreach($messages as $msg)
@if($id !== $msg['from_id'])
 <div class="container" style="width: 90%;margin: 20px;">   
  <span style="float: right;">@if(auth()->user()->role_id == 3) Patient @else Doctor @endif</span><br>
  <!-- <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" width="0" height="0" @if(auth()->user()->role_id == 3) alt="Patient" @else alt="Doctor" @endif> -->
  <p style="float: left;">{{$msg['body']}}
    @if($msg['attachment'] != null)
    <img src="{{asset('storage/attachments/'.$msg['attachment'].'.jpeg')}}" style="border-radius: 0%;">
    @endif
  </p>
  <span class="time-right">{{$msg['created_at']->diffForHumans()}}</span>
</div>
@else
<div class="container darker" style="width: 90%;margin: 20px;">
  <span style="float: left;">@if(auth()->user()->role_id == 3) Doctor @else Patient @endif</span><br>
  <!-- <img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" width="0" height="0" @if(auth()->user()->role_id == 3) alt="Doctor" @else alt="Patient" @endif class="right"> -->
  <p style="float: right;">{{$msg['body']}}
    @if($msg['attachment'] != null)
    <img src="{{asset('storage/attachments/'.$msg['attachment'].'.jpeg')}}" style="border-radius: 0%;">
    @endif
  </p>
  <span class="time-left">{{$msg['created_at']->diffForHumans()}}</span>
</div>
@endif
@endforeach

@endsection


@section('css')
<style type="text/css">
     /* Chat containers */
.container {
  width: 90%;
  padding-right: 15px;
  padding-left: 15px;
  border: 2px solid #dedede;
  background-color: #fff;
  border-radius: 5px;
  padding: 10px;
  margin: 20px;
}

/* Darker chat container */
.darker {
  border-color: #255985;
  background-color: #255985;
  color: #fff;
}

/* Clear floats */
.container::after {
  content: "";
  clear: both;
  display: table;
}

/* Style images */
.container img {
  float: left;
  max-width: 60px;
  width: 100%;
  margin-right: 20px;
  border-radius: 50%;
}

/* Style the right image */
.container img.right {
  float: right;
  margin-left: 20px;
  margin-right:0;
}

/* Style time text */
.time-right {
  float: right;
  color: #aaa;
}

/* Style time text */
.time-left {
  float: left;
  color: #999;
} 
</style>
@endsection