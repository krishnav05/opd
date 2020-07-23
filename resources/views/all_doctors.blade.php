@extends('voyager::master')


@section('content')
<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Doctor Name</th>
      <th scope="col">Summary</th>
      <th scope="col">Specialtiy</th>
      <th scope="col">Current Hospital</th>
      <th scope="col">Username</th>
      <th scope="col">Profile Photo</th>
      <th scope="col">Account Status</th>
      <th scope="col">Change Status</th>
      <th scope="col">Details</th>
    </tr>
  </thead>
  <tbody>
    @foreach($doctors as $doctor)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td>{{$doctor['name']}}</td>
      @foreach($doctordetails as $docdetails)
      @if($docdetails['doctor_id'] == $doctor['id'])
      <td>{{$docdetails['summary']}}</td>
      <td>{{$docdetails['speciality']}}</td>
      <td>{{$docdetails['current_hospital']}}</td>
      @endif
      @endforeach
      <td>{{$doctor['email']}}</td>
      <td><img src="/storage/users-avatar/{{$doctor['avatar']}}" height="50px" width="50px" alt="Italian Trulli"></td>
      <td>@if($doctor['enable'] == 1)
        Enabled
        @else
        Disabled
        @endif</td>
        <td>@if($doctor['enable'] == 1)
        <a href="/admin/disab/{{$doctor['id']}}">Disable</a>
        @else
        <a href="/admin/enab/{{$doctor['id']}}">Enable</a>
        @endif</td>
        <td><a href="/admin/doctor/{{$doctor['id']}}">View Details</a></td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection

@section('javascript')
<script type="text/javascript">
  
</script>
@endsection