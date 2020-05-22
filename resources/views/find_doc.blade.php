@extends('layouts.master')

@section('content')

<div class="container">
  
  <div class="row">
    <div class="col text-center">
      <img src="{{asset('assets/img/hero-find-doc.svg')}}" class="img-fluid mt-3 ">
    </div>
  </div>

<div id="app" class="col">
  
</div>
<h1 class="text-center mb-4">hang on! <br> finding a doctor for you</h1 class="text-center">
  
</div>


<div class="modal fade animate m-4" id="find-doc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content animate-bottom">
      
      <div class="modal-body">
       <h1 class="text-center mb-3"> Doctor is available!<br> you Chat now. </h1>
       <div class="doc-found m-auto text-center">
         <img src="{{asset('assets/img/doc-img.jpg')}}" class="doc-pic">
         <a href="#" class="doc-tap"><i class="fa fa-mobile fa-2x"></i></a>
         <h4>Available</h4>
         <h5>Dr. Rajiv Kochar</h5>
       </div>
        <input type="submit" formaction="" name="" value="start chatting" class="btn btn-primary form-control form-control-lg mt-3">
      
      </div>
    
    </div>
  </div>
</div>

@endsection

@section('footer')

<script type="text/javascript">
  setTimeout(function() {
    $('#find-doc').modal();
}, 20000);
</script>

@endsection