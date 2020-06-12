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
    </tr>
    @endforeach
  </tbody>
</table>
@endsection

@section('javascript')
<script type="text/javascript">
  
</script>
@endsection