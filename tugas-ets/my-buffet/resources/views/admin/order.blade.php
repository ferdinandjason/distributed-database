@extends('adminlte::page')

@section('css')
<style>
    html, body {
        padding-top: 0px !important;
    }

    .products-list .product-info {
        margin-left: 30px;
        margin-right: 30px;
    }
</style>
@stop

@section('content_header')
    <h1>
        Order Status
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Order</li>
    </ol>
    <meta http-equiv="refresh" content="5" />
@stop

@section('content')
    <!-- Info Box -->
    <div class="row">
        <div class="col-md-8">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Latest Orders</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>User</th>
                                    <th>Hotel</th>
                                    <th>Status</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td><a href="">{{$order->id}}</a></td>
                                    <td>{{$order->user->nama}}</td>
                                    <td>{{$order->restaurant->nama}}</td>
                                    @if($order->status == 0)
                                        <td><span class="label label-warning">New</span></td>
                                    @elseif($order->status == 1)
                                        <td><span class="label label-info">Confirmed</span></td>
                                    @elseif($order->status == 2)
                                        <td><span class="label label-warning">Placed</span></td>
                                    @elseif($order->status == 3)
                                        <td><span class="label label-success">Done</span></td>
                                    @endif
                                    <td>
                                        <div>
                                            @if($order->status == 0)
                                                <form action="{{route('admin.order.confirmed',$order->id)}}"><button type="submit" class="btn btn-success btn-sm">Lunas</button></form>
                                            @elseif($order->status == 1)
                                                <form action="{{route('admin.order.placed',$order->id)}}"><button type="submit" class="btn btn-success btn-sm">Placed</button></form>
                                            @else
                                                <button type="submit" disabled="true" class="btn btn-success btn-sm btn-disabled">Edit</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
            <!-- /.box-body -->
                <!-- <div class="box-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
                </div> -->
            <!-- /.box-footer -->
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header with-border">
                <h3 class="box-title">Recently Paid Order</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" id="asd">
                
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                <!-- <a href="javascript:void(0)" class="uppercase">View All Products</a> -->
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
        
    </div>


    


@stop

@section('js')
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    
    <script>
    $(document).ready(function() {
        $('#menu-restoran').DataTable();
        $.ajax({
            url: "{{route('api.transfered-order')}}", 
            success: function(obj){
                obj = obj.data;
                string =  "";
                for (let index = obj.length-1; index >= 0; --index){
                    let o = obj[index];
                    console.log(o);
                    string += 
                    "<ul class='products-list product-list-in-box'>"+
                        "<li class='item'>"+
                            "<div class='product-info'>"+
                                "<a class='product-title'> Order ID "+o.order_id+
                                "<span class='label label-warning pull-right'>"+o.total+"</span></a>"+
                                "<span class='product-description'>"+
                                    "Lunas !"+
                                "</span>"+
                            "</div>"+
                        "</li>"+
                    "</ul>"
                }
                $('#asd').html(string);
            }
        });
    } );
    </script>
@stop