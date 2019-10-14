@extends('adminlte::page')

@section('css')
<style>
    html, body {
        padding-top: 0px !important;
    }

    @media only screen and (max-width: 480px) {
        .box.box-success {
            overflow-x: auto;
        }
    }
</style>
@stop

@section('content_header')
    <h1>
        Hotel Menu
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Hotel</a></li>
        <li class="active">Menu</li>
    </ol>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Menu</h3>
            </div>
            <div class="box-body">
                <table id="menu-restoran" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                    <thead>
                    <tr role="row">
                        <th rowspan="1" colspan="1">Gambar</th>
                        <th rowspan="1" colspan="1">Nama</th>
                        <th rowspan="1" colspan="1">Deskripsi</th>
                        <th rowspan="1" colspan="1">Kategori</th>
                        <th rowspan="1" colspan="1">Stok</th>
                        <th rowspan="1" colspan="1">Harga</th>
                        <th rowspan="1" colspan="1">Opsi</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($menuRestaurants as $menu)
                            <tr role="row" class="odd">
                                <td class="sorting_1">
                                    <img src="{{Storage::url($menu->foto)}}" style="height: 140px;width: 140px;"/>
                                </td>
                                <td>{{$menu->nama_makanan}}</td>
                                <td>{{$menu->deskripsi}}</td>
                                <td>{{$menu->kategori}}</td>
                                <td>{{$menu->stok}}</td>
                                <td class="harga">{{$menu->harga}}</td>
                                <td>
                                    <div style="display:flex">
                                        <a href="menu/{{$menu->id}}/edit">
                                            <button type="button" class="btn btn-info" style="margin-left:10px;">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </button>
                                        </a>
                                        <form action="{{'menu/delete/'.$menu->id}}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}                                
                                            <button type="submit" class="btn btn-info btn-danger" style="margin-left:10px;">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th rowspan="1" colspan="1">Gambar</th>
                            <th rowspan="1" colspan="1">Nama</th>
                            <th rowspan="1" colspan="1">Deskripsi</th>
                            <th rowspan="1" colspan="1">Kategori</th>
                            <th rowspan="1" colspan="1">Stok</th>
                            <th rowspan="1" colspan="1">Harga</th>
                            <th rowspan="1" colspan="1">Opsi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
@stop

@section('js')
    <script>
    // $(document).ready(function() {
    //     $('#menu-restoran').DataTable();
    //     let a = $('.harga');
    //     for(let i = 0; i < a.length; i++){
    //         a[i].html('Rp '+numeral(a[i].html()).format('0,0'))
    //     }
    // } );
    </script>
@stop