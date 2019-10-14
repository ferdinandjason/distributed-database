@extends('adminlte::page')

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
        <form role="form" method="POST" action="{{route('restaurant.menu.update',$menuRestaurant->id)}}" enctype="multipart/form-data" id="menu-resto-update">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="nama_makanan">Nama</label>
                        <input type="text" class="form-control" id="nama_makanan" name="nama_makanan" placeholder="Nama menu" value="{{$menuRestaurant->nama_makanan}}">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi menu" value="{{$menuRestaurant->deskripsi}}">
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Kategori menu"  value="{{$menuRestaurant->kategori}}">
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="text" class="form-control" id="stok" name="stok" placeholder="Stok"  value="{{$menuRestaurant->stok}}">
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="text" class="form-control" id="harga" name="harga" placeholder="Harga menu"  value="{{$menuRestaurant->harga}}">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <div class="boxImage" id="foodBox">
                            <img id="foodImage" src="{{Storage::url($menuRestaurant->foto)}}" alt="your image"/>
                        </div>

                        <label for="foto">Gambar</label>
                        <input type="file" id="foto" name="foto">
                        <input type="hidden" id="new_image" name="new_image" value="">

                        <p class="help-block">Gambar harus dalam resolusi 1:1</p>
                    </div>
                </div>
                
                
            </div>
            <input type="hidden" id="restaurant_id" name="restaurant_id" value="{{\Auth('restaurant')->user()->id}}"/>
            
            <div class="col-md-12">
                <div class="box-footer">
                    <button type="submit" id="buttonedit" class="btn btn-success">Submit</button>
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
                $("#foodBox").css("padding-top", "0");

                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#foodImage').attr('src', e.target.result);
                    $('#foodImage').croppie({
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

            $('#foodImage').croppie('result', {
                type: 'canvas',
                size: {width: 450, height: 450}

            }).then(function (data) {
                $('input[name=new_image]').val(data);
                // alert($('input[name=new_image]').val());

                $("#menu-resto-update").submit();
            });
        })

    </script>
@stop