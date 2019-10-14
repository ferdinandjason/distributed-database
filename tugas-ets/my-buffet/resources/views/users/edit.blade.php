<!-- ini ui buat kalau mau edit profile pake $user --> 

@extends('adminlte::master')
@include('layouts.nav')

@section('adminlte_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.css">

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
            height: 90vh;
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

        .button-submit {
            position: absolute;
            bottom: 0;
            right: 20px;
        }

    </style>
@endsection


@section('body')
    <div class="container profile-container">
        
        <form id="edit-user-profile" role="form" method="POST" action="{{route('user.profile.update')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        
        <div class="row row-profile">
            
            <div class="left-profile col-md-4">
                <div class="form-group">
                    <div id="user-photo">
                        <img id="user-avatar" src="{{Storage::url($user->avatar)}}" alt="your image"/>
                    </div>

                    <label for="foto">Change Photo</label>
                    <input type="file" id="foto" name="foto">
                    <input type="hidden" id="new_image" name="new_image" value="">
                </div>
            </div>


            <div class="right-profile col-md-8">
                <div class="row profile-header">
                    <h1>{{$user->nama}}</h1>
                </div>

                <div class="row profile-personal">
                    <h1>Personal Info</h1>
                    <div class="personal-info">
                        <div class="table-row">
                            <h3 class="table-title">Username</h3>
                            <input type="text" class="form-control table-content" id="username" name="username" placeholder="{{ old('username') }}" value="{{ $user->username }}">
                            <!-- <h5 class="table-content">yolandahp</h5> -->
                        </div>
                        <div class="table-row">
                            <h3 class="table-title">Full Name</h3>
                            <input type="text" class="form-control table-content" id="fullname" name="nama" placeholder="{{ old('fullname') }}" value="{{ $user->nama }}">
                            <!-- <h5 class="table-content">Yolanda Hertita Pratama</h5> -->
                        </div>
                        <div class="table-row">
                            <h3 class="table-title">Email</h3>
                            <input type="email" class="form-control table-content" id="email" name="email" placeholder="{{ old('email') }}" value="{{ $user->email }}">
                            <!-- <h5 class="table-content">yolandahertita903@gmail.com</h5> -->
                        </div>
                        <div class="table-row">
                            <h3 class="table-title">Alamat</h3>
                            <input type="text" class="form-control table-content" id="alamat" name="alamat" placeholder="{{ old('alamat') }}" value="{{ $user->alamat }}">
                            <!-- <h5 class="table-content">Jln Teknik Komputer Gg II Perumahan dosen ITS Blok U no 26, ITS, Keputih, Sukolilo, Surabaya</h5> -->
                        </div>
                        <div class="table-row">
                            <h3 class="table-title">No Telp</h3>
                            <input type="text" class="form-control table-content" id="notelp" name="nomor_telepon" placeholder="{{ old('notelp') }}" value="{{ $user->nomor_telepon }}">
                            <!-- <h5 class="table-content">089648491314</h5> -->
                        </div>
                    </div>
                </div>

                <div class="row profile-password">
                    <h1>Password</h1>
                    <div class="password-account">
                        <div class="table-row">
                            <h3 class="table-title">Password</h3>
                            <input type="password" class="form-control table-content" id="password" name="passwd" placeholder="{{ old('password') }}" value="">
                            <!-- <h5 class="table-content">************</h5> -->
                        </div>
                        <div class="table-row">
                            <h3 class="table-title">New Password</h3>
                            <input type="password" class="form-control table-content" id="newpassword" name="password" value="">
                        </div>
                        <div class="table-row">
                            <h3 class="table-title">Confirm New Password</h3>
                            <input type="password" class="form-control table-content" id="confirmnewpassword" name="password_confirmation" value="">
                        </div>
                    </div>
                </div>
            
            </div>

            <div class="button-submit">
                <button type="submit" id="buttonedit" class="btn btn-success">Submit</button>
            </div>
        </div>

        </form>
    </div>
@endsection


@section('adminlte_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.js"></script>

    <script>

        function readURL(input) {            
            if (input.files && input.files[0]) {
                $("#user-photo").css("padding-top", "0");

                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#user-avatar').attr('src', e.target.result);
                    $('#user-avatar').croppie({
                        viewport: { width: 300, height: 300 },
                        boundary: { width: 300, height: 300 }
                    });

                    $(".croppie-container").css("height", "auto");   
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#foto").change(function() {
            readURL(this);
        });

        $("#buttonedit").click(function(e) {

            $('#user-avatar').croppie('result', {
                type: 'canvas',
                size: {width: 450, height: 450}

            }).then(function (data) {
                $('input[name=new_image]').val(data);
                // alert($('input[name=new_image]').val());

                $("#edit-resto-profile").submit();
            });
        })

    </script>
@endsection

