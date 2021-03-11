<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <meta name="description" content="Ask me Responsive Questions and Answers Template">
  <meta name="author" content="vbegy">
  <meta name="robots" content="all,follow">

  
  <!-- Mobile Specific Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


<!--   HackerTimer js S-->

  <script src="{{ asset('/js/HackTimer.js') }}"></script>
  <!--   HackerTimer js E-->


  <!-- Main Style -->
  <link rel="stylesheet" href="{{ asset('/ask_me/style.css') }}">
  
  <!-- Skins -->
  <link rel="stylesheet" href="{{ asset('/ask_me/css/skins/green.css') }}">
  
  <!-- Responsive Style -->
  <link rel="stylesheet" href="{{ asset('/ask_me/css/responsive.css') }}">

  <!-- Favicons -->
  <link rel="shortcut icon" href="{{ asset('/ask_me/images/favicon.png') }}">






  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">


 
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700">






  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
  <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">



<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->














<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>


  

  <link rel="stylesheet" href="{{ asset('/distribution/vendor/font-awesome/css/font-awesome.min.css') }}">

  <link rel="stylesheet" href="{{ asset('/distribution/vendor/bootstrap-select/css/bootstrap-select.min.css') }}">













</head>

<body>

<script src="{{ asset('/ask_me/js/jquery.min.js') }}"></script>
<script src="{{ asset('/ask_me/js/jquery-ui-1.10.3.custom.min.js') }}"></script>
<script src=" {{ asset('/ask_me/js/jquery.easing.1.3.min.js') }}"></script>
<script src="{{ asset('/ask_me/js/html5.js') }}"></script>
<script src="{{ asset('/ask_me/js/twitter/jquery.tweet.js') }}"></script>
<script src="{{ asset('/ask_me/js/jflickrfeed.min.js') }}"></script>
<script src="{{ asset('/ask_me/js/jquery.inview.min.js') }}"></script>



<script src="{{ asset('/ask_me/js/jquery.tipsy.js') }}"></script>
<script src="{{ asset('/ask_me/js/tabs.js') }}"></script>
<script src="{{ asset('/ask_me/js/jquery.flexslider.js') }}"></script>
<script src="{{ asset('/ask_me/js/jquery.prettyPhoto.js') }}"></script>
<script src="{{ asset('/ask_me/js/jquery.carouFredSel-6.2.1-packed.js') }}"></script>
<script src="{{ asset('/ask_me/js/jquery.scrollTo.js') }}"></script>
<script src="{{ asset('/ask_me/js/jquery.nav.js') }}"></script>
<script src="{{ asset('/ask_me/js/tags.js') }}"></script>
<script src="{{ asset('/ask_me/js/jquery.bxslider.min.js') }}"></script>
<script src="{{ asset('/ask_me/js/custom.js') }}"></script>  
 




  <script src="{{ asset('/js/application_global.js') }}"></script>

  @include('layouts/header')

 
  @yield('content')
     @include('layouts/footer')




 




  <!--     Custom Js start-->




@yield('page-script')
</body>
</html>