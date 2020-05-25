<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="robots" content="noindex, nofollow" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@300;500&display=swap" rel="stylesheet"> 
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/opd.css')}}">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <title>onlyOPD</title>
</head>
<body>
  <header>
    <div class="fluid-container">
      <div class="row m-0">
        <div class="col text-left pl-0"> <a class="fa fa-history fa-2x text-center" href=""> <span class="d-block">History</span> </a> </div>
        <div class="col text-center"> <a href="" onclick="return false;" class="logo"> only<span>OPD</span> </a> </div>
        <div class="col text-right pr-0"> <a class="credit text-center" href="credits"> <span class="
          credit-box">@if(isset($credit)) {{$credit}} @else 0 @endif</span> <span class="d-block">Credits</span> </a> </div>
        </div>
      </div>
    </header>

    @yield('content')


    <footer class="text-center p-2">
      <div class="container"> <a href="" onclick="return false;"> Terms </a> | <a href="" onclick="return false;"> Privacy </a> | &nbsp; 2020 &copy; Copyrights onlyOPD </div>
    </footer>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{asset('assets/js/opd-custom.js')}}"></script>

    @yield('footer')
  </body>
  </html>