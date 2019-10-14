@extends('adminlte::page')

@section('css')
<style>
    html, body {
        padding-top: 0px !important;
    }

    .hehe {
        min-width: 160px !important;
        height: 120px  !important;
        padding: 30px 10px !important;
        font-size: 16px !important;
    }

    .hehe2 {
        font-size: 30px !important;
    }
</style>
@stop

@section('content_header')
    <h1>
        Hotel Dashboard
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Hotel</a></li>
        <li class="active">Dashboard</li>  
    </ol>
@stop

@section('content')
<div class="box box-success order-main-box">
    <div class="box-body">
        <div class="row" style="text-align: center;margin: 30px;">
            <a class="btn btn-app hehe bg-olive" href="order">
                <!-- <span class="badge bg-green">300</span> --> 
                <i class="fa hehe2 fa-sticky-note"></i> Order
            </a>
            <a class="btn btn-app hehe bg-olive" href="order-history">
                <!-- <span class="badge bg-green">300</span> --> 
                <i class="fa hehe2 fa-sticky-note-o"></i> Order History
            </a>
            <a class="btn btn-app hehe bg-olive"  href="menu">
                <!-- <span class="badge bg-green">300</span> --> 
                <i class="fa hehe2 fa-navicon"></i> Menu
            </a>
            <a class="btn btn-app hehe bg-olive"  href="menu-new">
                <!-- <span class="badge bg-green">300</span> --> 
                <i class="fa hehe2 fa-plus-square"></i> Tambah Menu
            </a>
            <a class="btn btn-app hehe bg-olive" href="profile/{{Auth('restaurant')->user()->id}}">
                <!-- <span class="badge bg-green">300</span> --> 
                <i class="fa hehe2 fa-user"></i> Profile
            </a>
        </div>
    </div>
</div>
@stop