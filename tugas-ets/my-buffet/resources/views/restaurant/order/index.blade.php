@extends('adminlte::page')

@section('css')
<style>
    html, body {
        padding-top: 0px !important;
    }

    .order-main-box {
        border-top: None;
    }

    .box-header .col-md-4 .box-title {
        font-size: 14px;
    }

    .box-body .table tr td:nth-child(1) {
        padding-left:15px;
        width: calc((5/12)*100%);
    }

    .box-body .table tr td:nth-child(2) {
        padding-left:15px;
        width: calc((3/12)*100%);
    }

    .box-body .table tr td:nth-child(3) {
        padding-left: 15px;
        width: calc((4/12)*100%);
    }

    .box-footer .done-order {
        padding: 0 50px;
    }

</style>
@stop

@section('content_header')
    <h1>
        Hotel Order
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Hotel</a></li>
        <li class="active">Order</li>
    </ol>
@stop

@section('content')
        <div class="box box-success order-main-box">
            <div class="box-body">
            
            <div class="row">
            @forelse ($orders as $order)
                <div class="col-md-3">
                    <div class="box">
                        <div class="box-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <h3 class="box-title">Order <b>#{{$order->id}}</b></h3>
                                </div>
                                <div class="col-md-4">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                    <h3 class="box-title">User <b>{{$order->user->nama}}</b></h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <table class="table table-condensed">
                                <tbody>
                                @foreach ($order->details as $item)
                                <tr>
                                    <td>{{$item->menuRestaurant->nama_makanan}}</td>
                                    <td>{{$item->amount}}</td>
                                    <td class="harga">{{$item->sub_total}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><b>Note: </b>{{$order->comments}}</p>
                                </div>
                                @if($order->delivery == 1)
                                <div class="col-md-6">
                                    <p><b>Alamat: </b>{{$order->alamat}}</p>
                                </div>
                                @endif
                                <div class="col-md-6" style="display: flex;justify-content: space-between;">
                                    <b>Total: </b><p class="harga">{{$order->total}}</p>
                                </div>
                            </div>
                            
                            <div class="done-order">
                                <form action={{route('restaurant.order.done', ['id' => $order->id])}} method="POST">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-success btn-xs btn-block">Done</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12"><p>No Order Right Now!</p></div>
            @endforelse
            </div>

            </div>
        </div>
        <!-- /.box -->
@stop

@section('js')
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    
    <script>
    </script>
@stop