@extends('adminlte::master')

@section('adminlte_css')
    <style>

        .card {
            background-color: #fff;
            border: 1px solid #eee; 
            border-radius: 6px;
        }

        .card .card-img img { 
            border-radius: 6px 6px 0 0;
            transition: all 1s;
        }

        .card .card-img:hover img { 
            transform: scale(1.1);
        }

        .card .card-img { 
            position: relative; 
            padding: 0; 
            display: table; 
        }

        .card-img-border {
            position: relative;
            overflow: hidden;
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

        .card-body h5 a {
            color: #72B01D;
        }

        .card-body h5 a:hover {
            color: #3F7D20;
        }

        .card .card-body p {
            margin-top: 6px;
            margin-bottom: 12px;
        }

        .row.equal {
            display: flex;
            flex-wrap: wrap;
        }

        .row.equal .col-md-3 {
            margin-bottom: 20px;
            padding-left: 10px;
            padding-right: 10px;
        }

    </style>
@stop

@section('body')
    @include('layouts.nav')
    <div class="container">
        <div class="row equal">
            @foreach ($restaurants as $resto)
            
            <div class="col-md-3">
            <div class="card">
                <span class="card-img">
                    <div class="card-img-border">
                        <img src="{{Storage::url($resto->avatar)}}" class="img-responsive">
                    </div>

                    <div class="card-body">
                        <h5><b><a href="{{route('user.resto', $resto->id)}}">
                            {{$resto->nama}}
                        </a></b></h5>
                        <p>{{$resto->alamat}}</p>
                    </div>
                </span>
            </div>
            </div>

            @endforeach
        </div>
    </div>
@stop
