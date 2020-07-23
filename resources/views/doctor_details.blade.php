@extends('voyager::master')


@section('content')
<div class="col" style="margin-left: 10px; margin-right: 10px;">
  <br>
  <div class="row">
    <h5 style="text-align: center;">CONSULTATIONS</h5>
    <br>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Consultation Id</th>
      <th scope="col">Patient</th>
      <th scope="col">Session Duration</th>
      <th scope="col">Session Start</th>
      <th scope="col">Session End</th>
      <th scope="col">Wait Time</th>
      <th scope="col">Patient Location</th>
      <th scope="col">Doctor Location</th>
    </tr>
  </thead>
  <tbody>
    @foreach($consultations as $consult)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td>{{$consult['id']}}</td>
      @foreach($patients as $patient)
      @if($patient['id'] == $consult['patientId'])
      <td>{{$patient['phone']}}</td>
      @endif
      @endforeach
      <td>{{intval((strtotime($consult['updated_at'])-strtotime($consult['created_at']))/60)}} minutes</td>
      <td>{{$consult['created_at']}}</td>
      <td>{{$consult['updated_at']}}</td>
      <td>{{$consult['wait_time']/60}} minutes</td>
      <td>{{$consult['patient_location']}}</td>
      <td>{{$consult['doctor_location']}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
  </div>
</div>
@endsection

@section('javascript')
@endsection