@extends('voyager::master')


@section('content')
<div class="col" style="margin-left: 10px; margin-right: 10px;">
  <div class="row">
    <h5 style="text-align: center;">CREDITS</h5>
    <span style="margin-left: 10px;">Current Credits</span>
    <input type="text" size="5" value="{{$credits}}" readonly>
    <form action="/admin/addCredits" method="post" style="float: right;">
      @csrf
      <input type="hidden" name="id" value="{{$id}}">
    <input type="number" size="5" name="credit">
    <input type="submit" name="submit" value="Update Credits">
    </form>
  </div>
  <br>
  <div class="row">
    <h5 style="text-align: center;">TRANSACTIONS</h5>
    <br>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Transaction Amount</th>
      <th scope="col">Date & Time</th>
    </tr>
  </thead>
  <tbody>
    @foreach($transactions as $trans)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td>₹ {{$trans['amount']}}</td>
      <td>{{$trans['created_at']}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
  </div>
  <br>
  <div class="row">
    <h5 style="text-align: center;">CONSULTATIONS</h5>
    <br>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Consultation Id</th>
      <th scope="col">Doctor Name</th>
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
      @foreach($doctors as $doctor)
      @if($doctor['id'] == $consult['doctorId'])
      <td>{{$doctor['name']}}</td>
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
<script type="text/javascript">
</script>
@endsection