@extends('adminlte::master')
@include('layouts.nav')

<!-- <h1>User Dashboard<h1>
<a href={{route('user.order')}}> Order </a> -->

@section('adminlte_css')
    <style>
        html, body{
            padding-top: 25px;
            background-color: #F3EFF5;
        }

        .carousel-inner>.item>img{
            width: 100%;
        }

        .carousel-caption{
            top: 40%;
        }

        .carousel-caption>.outer-order-form>h1{
            font-size: 32px;
            padding-bottom: 15px;
        }

        .overlay{
            position: absolute;
            display: block;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgb(69,73,85, 0.3);
        }

        a.button-find{
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

        a.button-find:active{
            top:0.1em;
        }

        .best-restaurants>.container, .recent-restaurants>.container{
            padding-top: 5vh;
            padding-bottom: 10vh;
        }

        .recent-restaurants{
            background-color: #FFFFFF;
        }

        .card {
            background-color: #fff;
            border: 1px solid #eee; 
            border-radius: 6px; 
        }

        .card .card-img img { 
            border-radius: 6px 6px 0 0; 
        }

        .card .card-img { 
            position: relative; 
            padding: 0; 
            display: table; 
        }

        .card .card-body {
            display: table; 
            width: 100%; 
            padding: 12px;
        }

        .card .card-body h5, .card .card-body h4 {
            text-transform: uppercase;
            margin: 0;
        }

        .card .card-body p {
            margin-top: 6px;
            margin-bottom: 12px;
        }

        .card-container {
            overflow-x: auto;
            overflow-y: hidden;
            display: flex;
            flex-wrap: nowrap;
        }

        .card-container .card {
            display: inline-block;
            min-width: 200px;
            width: 30%;
            flex: 0 0 auto;
            margin: 0 10px 10px 0;
        }

        .container h1{
            color: #3F7D20;
        }

        .card-body h5 a {
            color: #72B01D;
        }

        .card-body h5 a:hover {
            color: #3F7D20;
        }

        @media only screen and (max-width: 480px) {
            .carousel-caption {
                top: auto;
            }

            .carousel-caption>.outer-order-form>h1 {
                font-size: 20px;
                padding-bottom: unset;
            }

            a.button-find {
                padding: 0.3em 2em;
                font-size: 16px;
                border-radius: 0.3em;
            }


        
        }

    </style>
@endsection

@section('body')
<div class="bs-example">
    <div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
    	<!-- Carousel indicators -->
        <ol class="carousel-indicators">
            <li class="slide-one active"></li>
            <li class="slide-two"></li>
            <li class="slide-three"></li>
        </ol>   
        <!-- Wrapper for carousel items -->
        <div class="carousel-inner">
            <div class="active item">
                <img src="{{asset('/images/home-slider1.jpg')}}" alt="First Slide">
            </div>
            <div class="item">
                <img src="{{asset('/images/home-slider2.jpg')}}" alt="Second Slide">
            </div>
            <div class="item">
                <img src="{{asset('/images/home-slider3.jpg')}}" alt="Third Slide">
            </div>

            <div class="carousel-caption">
                <div class="outer-order-form">
                    <h1 class="text-center">Order your favourite food at any place</h1>
                </div>

                <a href={{route('user.order')}} class="button-find">Find Restaurants</a>

            </div>

            
        </div>

        <div class="overlay"></div>
    
    </div>
</div>

<div class="best-restaurants">
    <div class="container">
    <h1>Popular Restaurants</h1>
        
        <div class="card-container">
        @foreach($data['bestResto'] as $resto)
            <div class="card">
                <span class="card-img">
                    <img src="{{Storage::url($resto->restaurant->avatar)}}" class="img-responsive">
                    <div class="card-body">
                        <h5><b><a href="{{route('user.resto', $resto->restaurant->id)}}">
                            {{$resto->restaurant->nama}}
                        </a></b></h5>
                        <p>{{$resto->restaurant->alamat}}</p>
                    </div>
                </span>
            </div>
        @endforeach
        </div>

    </div>
</div>


<div class="recent-restaurants">
    <div class="container">
        <h1>Recent Hotel</h1>

        <div class="card-container">
        
        @foreach($data['recentResto'] as $resto)
            <div class="card">
                <span class="card-img">
                    <img src="{{Storage::url($resto->restaurant->avatar)}}" class="img-responsive">
                    <div class="card-body">
                        <h5><b><a href="{{route('user.resto', $resto->restaurant->id)}}">
                            {{$resto->restaurant->nama}}
                        </a></b></h5>
                        <p>{{$resto->restaurant->alamat}}</p>
                    </div>
                </span>
            </div>
        @endforeach
        
        </div>

    </div>
</div>

@endsection