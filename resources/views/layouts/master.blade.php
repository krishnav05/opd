<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="robots" content="noindex, nofollow" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @yield('css')
  <!-- Bootstrap CSS -->
  <link rel="apple-touch-icon" href="{{asset('assets/img/touch-icon-iphone.png')}}">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@300;500&display=swap" rel="stylesheet"> 
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/opd.css')}}">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <title>doksaa</title>
</head>
<body>
  <header>
    <div class="fluid-container">
      <div class="row m-0">
        
        <div class="col text-left pl-0"> @if(Auth::check()) @if(isset($doctorprofile)) <a href="call-pickup"><i class="fa fa-chevron-left fa-2x"></i></a> @endif @if(Auth::check()) @if(isset($check)) <a onclick="window.history.back();"> <i class="fa fa-chevron-left fa-2x"></i></a>  @else  @if(isset($doctorprofile)) @else <a class="fa fa-history fa-2x text-center" href="/history"> <span class="d-block">History</span></a>@endif @endif @endif @endif @if(isset($contact)) <a onclick="window.history.back();"> <i class="fa fa-chevron-left fa-2x"></i></a>  @endif</div>
        <div class="col text-center"> <a href="/" class="logo"> <img src="/assets/img/doksaa.png"> </a> </div>
        <div class="col text-right pr-0">@if(Auth::check()) @if(isset($check)) @else<a class="credit text-center" @if(Auth::check() && Auth::user()->role_id == 3) href="profile" @else href="credits" @endif> @if(Auth::check() && Auth::user()->role_id == 3) <span class="
          credit-box doc-profile"><img src="/storage/users-avatar/{{Auth::user()->avatar}}" style="border-radius: 50%; height: 40px; width: 40px;" > @else <span class="
          credit-box"> @if(isset($credit)) {{$credit}} @else 0 @endif @endif</span>@if(Auth::check() && Auth::user()->role_id == 3) @else <span class="d-block"> Credits</span> @endif </a> @endif @endif</div>
        </div>
      </div>
    </header>

    @yield('content')


    <!-- <footer class="text-center p-2">
      <div class="container"> <a href="" onclick="return false;"> Terms </a> | <a href="" onclick="return false;"> Privacy </a> | &nbsp; 2020 &copy; Copyrights onlyOPD </div>
    </footer> -->



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{asset('assets/js/opd-custom.js')}}"></script>

    @yield('footer')
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-167493010-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-167493010-1');
</script>
  </body>
  </html>