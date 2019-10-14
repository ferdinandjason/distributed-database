@extends('adminlte::master')

@section('adminlte_css')
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

    <style>
        .homepage-hero {
            height: 85vh;
        }

        .homepage-hero .hero-container {
            position: absolute;
            top: 40%;
            -ms-transform: translateY(-40%);
            transform: translateY(-40%);
        }

        .homepage-hero .hero-container h1 {
            font-size: 32px;
            font-weight: 900;
            color: #F3EFF5;
            margin-bottom: 45px;
        }
        
        .homepage-hero .hero-container h5 {
            color: #F3EFF5;
            margin-bottom: 45px;
        }


        .homepage-hero .hero-container h3 {
            color: #F3EFF5;
            font-size: 18px;
        }

        .homepage-hero .hero-container h5 a {
            color: #72B01D;
        }

        .homepage-hero .hero-container h5 a:hover {
            color: #3F7D20;
        }

        .homepage-hero .hero-container h3 a {
            color: #72B01D;
        }

        .homepage-hero .hero-container h3 a:hover {
            color: #3F7D20;
        }


        a.button-register {
            display: inline-block;
            padding: 0.8em 5em;
            margin: 0 0.5em 0.5em 0;
            border-radius: 0.5em;
            box-sizing: border-box;
            text-decoration: none;
            font-size: 18px;
            color: #FFFFFF;
            background-color: #72B01D;
            box-shadow: inset 0 -0.6em 0 -0.35em rgba(0, 0, 0, 0.17);
            text-align: center;
            position: relative;
        }

        a.button-register:active {
            top:0.1em;
        }
            
        @media all and (max-width:30em) {
            a.button-register {
                display:block;
                margin:0.4em auto;
            }
        }

        .overlay{
            position: absolute;
            display: block;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgb(69,73,85, 0.5);
            z-index: -1;
        }

        .homepage-how .how-container {
            background: #F3EFF5;
            text-align: center;
            padding-top: 10px;
        }

        .how-container h3 {
            font-size: 24px;
            color: #3F7D20;
            margin-bottom: 25px;
        }

        .how-icon-set .row {
            margin-right: 75px;
            margin-left: 75px;
        }

        .how-icon-set .how-icon {
            width: 120px;
        }

        .how-icon-set .col-md-4 h5 {
            padding-left: 70px;
            padding-right: 70px;
            color: #454955
        }

        @media only screen and (max-width: 480px) {
            .homepage-hero .hero-container {
                text-align: center;
                padding-right: 15px;
            }

            .how-icon-set .col-md-4 h5 {
                padding-left: 30px;
                padding-right: 30px;
            }


        }

    </style>
@stop

@section('body')
    @include('layouts.nav')
    <section class="homepage-hero">
        <div class="container">
            <div class="hero-container">
                <h1>Order your favourite food at any place</h1>
                <h3>What are you waiting for?</h3>
                @if (Auth::check())
                    <a href="{{route('user.home')}}" class="button-register">Go to Dashboard</a>
                @else
                    <a href="{{url('/register')}}" class="button-register">Register Now!</a>
                    <h5>Already have an account?  <a href="{{url('/login')}}">Login</a></h5>
                    <h3>Are you a Restaurant Owner?  <a href="{{url('/login/restaurant')}}">Join Us!</a></h3>
                @endif
            </div>
            
            <div class="overlay"></div>
        </div>
    </section>
        
    <section class="homepage-how">
        <div class="how-container">
            <h3>How It Works</h3>
            <div class="how-icon-set">
                <div class="row">
                    <div class="col-md-4">
                        <img class="how-icon" src="{{asset('/images/shop.png')}}"/>
                        <h5>1. Find Restaurants or Hotels and browse hundred of menus to find the food you like</h5>
                    </div>
                    <div class="col-md-4">
                        <img class="how-icon" src="{{asset('/images/payment.png')}}"/>
                        <h5>2. Choose your payment. You can pay fast & secure online or on the Restaurant</h5>
                    </div>
                    <div class="col-md-4">
                        <img class="how-icon" src="{{asset('/images/fooddome.png')}}"/>
                        <h5>3. Food gets prepared & delivered to your door by the Restaurant or you can pick up on the Restaurant</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@stop