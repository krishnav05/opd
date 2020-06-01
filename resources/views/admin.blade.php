@extends('voyager::master')


@section('content')
<form action="/admin/doctor" method="POST" enctype="multipart/form-data">
  @csrf
<table class="table">
  <thead>
    <tr>
      <th>Input</th>
      <th>Values</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Doctor Name</td>
      <td><input type="text" name="doctor_name" class="form-control-plaintext" value="" placeholder="" size="50"></td>
    </tr>
    <tr>
      <td>Summary</td>
      <td><input type="text" name="summary" class="form-control-plaintext" value="" placeholder="" size="50"></td>
    </tr>
    <tr>
      <td>Speciality</td>
      <td><input type="text" name="speciality" class="form-control-plaintext" value="" placeholder="" size="50"></td>
    </tr>
    <tr>
      <td>Current hospital</td>
      <td><input type="text" name="hospital" class="form-control-plaintext" value="" placeholder="" size="50"></td>
    </tr>
    <tr>
      <td>Username</td>
      <td><input type="text" name="email" class="form-control-plaintext" value="" placeholder="" size="50"></td>
    </tr>
    <tr>
      <td>Password</td>
      <td><input type="text" name="password" class="form-control-plaintext" value="" placeholder="" size="50"></td>
    </tr>
    <tr>
      <td>Image</td>
      <td><input type="file" name="photo"></td>
    </tr>
    <tr>
      <td><button type="submit" class="btn btn-primary">Add Doctor</button></td>
      <td></td>
    </tr>
  </tbody>
</table>
</form>
@endsection

@section('javascript')
<script type="text/javascript">
</script>
@endsection