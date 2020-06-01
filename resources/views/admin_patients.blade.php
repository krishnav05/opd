@extends('voyager::master')


@section('content')
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Patient</th>
      <th scope="col">Action</th>
      <th scope="col">Account Status</th>
      <th scope="col">Change Account Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach($patients as $patient)
    <tr>
      <th scope="row">{{ ($patients->currentpage()-1) * $patients->perpage() + $loop->index + 1 }}</th>
      <td>+91 {{$patient['phone']}}</td>
      <td><a href="/admin/patients/{{$patient['phone']}}">View Details</a> </td>
      <td>
        @if($patient['enable'] == 1)
        Enabled
        @else
        Disabled
        @endif
      </td>
      <td>
        @if($patient['enable'] == 1)
        <a href="/admin/disable/{{$patient['phone']}}">Disable</a>
        @else
        <a href="/admin/enable/{{$patient['phone']}}">Enable</a>
        @endif
      </td>

    </tr>
    @endforeach


  </tbody>
</table>
{{$patients->links()}}
@endsection

@section('javascript')
<script type="text/javascript">
</script>
@endsection