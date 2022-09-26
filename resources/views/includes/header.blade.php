<?php

use Illuminate\Support\Facades\URL;

    $url = url('/');
    $cur = URL::current();
    $ex = explode($url,$cur);
    if(!empty($ex[1])){
        $ex1 = explode('/',$ex[1]);
    }


?>

<!doctype html>
<html>

<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-P9L3HLZ');</script>
    <!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <title>{{isset($title)?$title:"Permit Search" }}</title>
    <meta name="description" content="{{isset($description)?$description:"Permit Search" }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('/images/permit.png') }}" sizes="32x32" type="image/x-icon">

     <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/permitsearch.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/devCustom.css') }}">
    <script src="{{ url('/js/jquery.min.js') }}"></script>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->
    <style>

    /*.loaderr {
        position: absolute;
        left: 50%;
        top: 60%;
        z-index: 1;
        width: 120px;
        height: 120px;
        margin: -76px 0 0 -76px;
        border: 10px solid #f3f3f3;
        border-radius: 50%;
        border-top: 15px solid #3498db;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }*/

    /* Safari */
  /*  @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }*/
</style>
</head>

<style>
    #overlay{
      position: fixed;
      top: 0;
      z-index: 100;
      width: 100%;
      height:100%;
      display: none;
      background: rgba(0,0,0,0.6);
    }
    .cv-spinner {
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .spinner {
      width: 40px;
      height: 40px;
      border: 4px #ddd solid;
      border-top: 4px #2e93e6 solid;
      border-radius: 50%;
      animation: sp-anime 0.8s infinite linear;
    }
    @keyframes sp-anime {
      100% {
        transform: rotate(360deg);
      }
    }
</style>

@if(!empty($ex[1]))
    @if($ex1[1] == 'search-result')
        <body class="popup-open">
    @else
        <body>
    @endif
@else
    <body>
@endif
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P9L3HLZ"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <header id="header">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg px-5">
                <a class="navbar-brand m-0 p-0" href="{{ url('/') }}">
                    <figure><img src="{{ asset('/images/logo.png') }}" alt="img-logo"> </figure>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        {{-- <li class="nav-item active">
                            <a class="nav-link" href="{{ url('/') }}">Home<span class="sr-only">(current)</span></a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/about-us') }}">About<span class="sr-only">(current)</span></a>
                        </li>
                        {{-- <li class="nav-item ">
                            <a class="nav-link" href="{{ url('/contact-us') }}">Contact Us<span class="sr-only">(current)</span></a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}#how-it-works">How it Works</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/pricing') }}">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/pro') }}">Pro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/faq') }}">FAQ</a>
                        </li>

                        @if(Auth::guard('web')->check())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Account
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" style="color: #212529 !important;" href="{{ url('/dashboard/account') }}">Profile</a>
                                    <a class="dropdown-item" style="color: #212529 !important;" href="{{ url('/dashboard/permit/my-report') }}">Reports</a>
                                    <a class="dropdown-item" style="color: #212529 !important;" href="{{ url('/dashboard/account/subscription') }}">Subscription</a>
                                    <a class="dropdown-item" style="color: #212529 !important;" href="{{ url('/dashboard/account/billing') }}">Billing History</a>
                                     <a class="dropdown-item" style="color: #212529 !important;" href="{{ url('/dashboard/permit-requests') }}">Permit Requests</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" style="color: #212529 !important;" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link" href="{{url('dashboard/account')}}" >
                                    @if(file_exists(asset('storage/images/users/'.Auth::user()->user_image)))
                                        <img class="img img-fluid avatar" src="{{asset('storage/images/users/'.Auth::user()->user_image)}}"></a>
                                    @else
                                        <img class="img img-fluid avatar" src="{{asset("images/user_sample.png")}}"></a>
                                    @endif
                            </li>
                        @else
                            {{-- @if(empty($ex[1])) --}}
                                <li class="nav-item">
                                    <a class="nav-link btnn" href="#">Login</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link open-signup" href="#">Sign Up</a>
                                </li> --}}
                            {{-- @endif --}}
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
    </header>

@if(request()->ref=='login')
    <script type="text/javascript">
        $(function(){
            $('.btnn').click();
        });
    </script>
@endif
