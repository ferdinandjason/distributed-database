<!--  ini ui buat front end pake $user buat akses varnya -->

@extends('adminlte::master')
@include('layouts.nav')

@section('adminlte_css')
    <style>
        html, body{
            padding-top: 25px;
            background-color: #72B01D;
        }

        .profile-container {
            background-color: #FFFFFF;
            margin-top: 5vh;
            margin-bottom: 5vh;
            border-radius: 15px;
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
            padding-top: 100%;
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

    </style>
@endsection


@section('body')
    <div class="container profile-container">
        <div class="row row-profile">
            <div class="edit-profile">
                <button type="button" class="button-edit" onclick="location.href='{{route('user.profile.edit')}}'">Edit Profile</button>
            </div>
            
            <div class="left-profile col-md-4"> 
                <div id="user-photo">
                    <img id="user-avatar" src="{{Storage::url($user->avatar)}}" alt="your image"/>
                </div>
            </div>

            <div class="right-profile col-md-8">
                <div class="row profile-header">
                    <h1>{{$user->nama}}</h1>
                    <h5><b>Joined at: </b>{{\Carbon\Carbon::parse($user->created_at)->toFormattedDateString()}}</h5>
                </div>

                <div class="row profile-personal">
                    <h1>Personal Info</h1>
                    <div class="personal-info">
                        <div class="table-row">
                            <h3 class="table-title">Username</h3>
                            <h5 class="table-content">{{$user->username}}</h5>
                        </div>
                        <div class="table-row">
                            <h3 class="table-title">Full Name</h3>
                            <h5 class="table-content">{{$user->nama}}</h5>
                        </div>
                        <div class="table-row">
                            <h3 class="table-title">Email</h3>
                            <h5 class="table-content">{{$user->email}}</h5>
                        </div>
                        <div class="table-row">
                            <h3 class="table-title">Alamat</h3>
                            <h5 class="table-content">{{$user->alamat}}</h5>
                        </div>
                        <div class="table-row">
                            <h3 class="table-title">No Telp</h3>
                            <h5 class="table-content">{{$user->nomor_telepon}}</h5>
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
@endsection

