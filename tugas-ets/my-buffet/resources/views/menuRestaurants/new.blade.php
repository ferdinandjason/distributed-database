@extends('adminlte::page')

<?php
    if(isset($_POST[''])){
        $data = $_POST['imagebase64'];

        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        file_put_contents('image64.png', $data);
    }
?>

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.css">

<style>
    html, body {
        padding-top: 0px !important;
    }

    .boxImage {
        position: relative;
        width: 100%;
        padding-top: 100%;
    }

    .boxImage #foodImage {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        width: 100%;
        height: 100%;
    }

    .col-md-12 .box-footer {
        text-align: center;
    }

    .col-md-12 .box-footer button {
        width: 20%;
    }

</style>
@stop

@section('content_header')
    <h1>
        Hotel Menu
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Hotel</a></li>
        <li class="">Menu</li>
        <li class="active">New</li>
    </ol>
@stop

@section('content')

<div class="box box-success">
    <div class="row">
        <form id="addnewform" role="form" method="POST" action="{{route('restaurant.menu.store')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="nama_makanan">Nama</label>
                        <input type="text" class="form-control" id="nama_makanan" name="nama_makanan" placeholder="Nama menu">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi menu">
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Kategori menu">
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="text" class="form-control" id="stok" name="stok" placeholder="Stok">
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="text" class="form-control" id="harga" name="harga" placeholder="Harga menu">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <div class="boxImage" id="boxImageId">
                            <img id="foodImage" src="{{asset('/images/foodbefore.jpg')}}" alt="your image"/>
                        </div>

                        <label for="foto">Gambar</label>
                        <input type="file" id="foto" name="foto">

                        <p class="help-block">Gambar harus dalam resolusi 1:1</p>
                    </div>
                </div>
                
                
            </div>
            <input type="hidden" id="restaurant_id" name="restaurant_id" value="{{\Auth('restaurant')->user()->id}}"/>
            <input type="hidden" id="new_image" name="new_image" value="">
            
            <div class="col-md-12">
                <div class="box-footer">
                    <button id="buttonaddnew" class="btn btn-success">Submit</button>
                </div>
            </div>
            
        </form>
    </div>
</div>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#menu-restoran').DataTable();
        } );

        function readURL(input) {            
            if (input.files && input.files[0]) {
                boxImageId.style.paddingTop = "0";

                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#foodImage').attr('src', e.target.result);
                    
                    $('#foodImage').croppie({
                        viewport: { width: 300, height: 300 },
                        boundary: { width: 300, height: 300 }
                    });
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#foto").change(function() {
            readURL(this);
        });

        $("#buttonaddnew").click(function(e) {

            $('#foodImage').croppie('result', {
                type: 'canvas',
                size: {width: 450, height: 450}

            }).then(function (data) {
                $('input[name=new_image]').val(data);
                // alert($('input[name=new_image]').val());

                $("#addnewform").submit();
            });
        })



        

    </script>
@stop