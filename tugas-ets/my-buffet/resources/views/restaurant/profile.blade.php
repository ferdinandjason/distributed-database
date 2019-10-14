<!-- ini ui buat restaurant $restaurant buat akses variablenya -->

@extends('adminlte::page')

@section('css')
<style>
    html, body {
        padding-top: 0px !important;
    }

        .profile-container {
            margin-bottom: 5vh;
            border-radius: 15px;
            width: 100%;
        }

        .row-profile {
            height: 80vh;
            margin-top: 10px;
            position: relative;
        }

        .left-profile {
            padding: 20px 60px 0 60px;
        }

        .right-profile {
            padding: 20px 0 0 60px;
        }

        #user-photo {
            position: relative;
            width: 100%;
            padding-top: 60%;
        }

        #user-photo #user-avatar {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
        }

        .personal-info, .password-account{
            display: table;
            width: 80%;
            border-spacing: 8px;
            table-layout: fixed;
        }

        .table-row {
            display: table-row;
        }

        .table-title, .table-content {
            display: table-cell;
        }

        .table-title {
            margin-right: 50px;
        }

        .edit-profile {
            position:absolute;
            top:10px;
            right:10px;
            z-index: 1;
        }

        @media only screen and (max-width: 480px) {
            .edit-profile {
                top: -25px;
                right: 0px;
            }

            .row-profile {
                height: auto;
            }

            .left-profile {
                padding: 10px 30px 0 30px;
            }

            .right-profile {
                padding: 20px 0 0 30px;
            }

            .personal-info, .password-account {
                width: 90%;
            }


        }
</style>
@stop

@section('content_header')
    <h1>
        My Profile
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Hotel</a></li>
        <li class="active">Profile</li>
    </ol>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                
            </div>
            <div class="box-body">

                <div class="container profile-container">
                    <div class="row row-profile">
                        <div class="edit-profile">
                            <button type="button" class="button-edit" onclick="location.href='{{route('restaurant.profile.edit')}}'">Edit Profile</button>
                        </div>
                        
                        <div class="left-profile col-md-4">
                            <div id="user-photo">
                                <img id="user-avatar" src="{{Storage::url($restaurant->avatar)}}" alt="your image"/>
                                <!-- <img id="user-avatar" src="{{asset('/images/restodefault.png')}}" alt="your image"/> -->
                            </div>
                        </div>

                        <div class="right-profile col-md-8">
                            <div class="row profile-header">
                                <h1>{{$restaurant->nama}}</h1>
                                <h5><b>Joined at: </b>{{\Carbon\Carbon::parse($restaurant->created_at)->toFormattedDateString()}}</h5>
                            </div>

                            <div class="row profile-personal">
                                <h1>Personal Info</h1>
                                <div class="personal-info">
                                    <div class="table-row">
                                        <h3 class="table-title">Username</h3>
                                        <h5 class="table-content">{{$restaurant->username}}</h5>
                                    </div>
                                    <div class="table-row">
                                        <h3 class="table-title">Name</h3>
                                        <h5 class="table-content">{{$restaurant->nama}}</h5>
                                    </div>
                                    <div class="table-row">
                                        <h3 class="table-title">Alamat</h3>
                                        <h5 class="table-content">{{$restaurant->alamat}}</h5>
                                    </div>
                                    <div class="table-row">
                                        <h3 class="table-title">No Telp</h3>
                                        <h5 class="table-content">{{$restaurant->nomor_telepon}}</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="row profile-password">
                                <h1>Password</h1>
                                <div class="password-account">
                                    <div class="table-row">
                                        <h3 class="table-title">Password</h3>
                                        <h5 class="table-content">************</h5>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                </div>

            </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
@stop

@section('js')
    
@stop