@extends('adminlte::page')

@section('css')
    <style>
        html, body {
            padding-top: 0px !important;
        }

        .box-body.table-responsive {
            padding-top: 20px;
        }

        .detail-order {
            display: table;
            width: 100%;
        }

        .detail-row {
            display: table-row;
        }

        .detail-col {
            display: table-cell;
        }

        .label-status {
            padding: 8px 16px !important;
        }

    </style>
@endsection

@section('content_header')
    <h1>
        Order History
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Hotel</a></li>
        <li><a href="#"><i></i> Order</a></li>
        <li class="active"> History</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-success">
            <div class="box-header">
                <div class="box-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Created At</th>
                            <th>Total</th>
                            <th>Comments</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>{{$order->total}}</td>
                            <td class="comments">{{$order->comments}}</td>
                            <td class="alamat">{{$order->alamat}}</td>

                            @if($order->status == 0)
                                <td><span class="label label-status label-warning">New</span></td>
                            @elseif($order->status == 1)
                                <td><span class="label label-status label-info">Confirmed</span></td>
                            @elseif($order->status == 2)
                                <td><span class="label label-status label-warning">Placed</span></td>
                            @elseif($order->status == 3)
                                <td><span class="label label-status label-success">Done</span></td>
                            @endif

                            <td>
                                <div style="display:flex">
                                    <a href="#">
                                        <button type="button" class="btn btn-success" style="margin-left:10px;" data-toggle="modal" data-target="#modal-detail"> 
                                            <span class="glyphicon glyphicon-eye-open"></span>
                                        </button>
                                    </a>
                                </div>
                            </td>

                            <div class="modal fade" id="modal-detail" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Order Detail</h4>
                                        </div>
                                        
                                        <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
                                            <div class="detail-order">
                                                <div class="detail-row">
                                                    <div class="detail-col"><h3>Menu</h3></div>
                                                    <div class="detail-col"><h3>Jumlah</h3></div>
                                                    <div class="detail-col"><h3>Sub Total</h3></div>
                                                </div>

                                                @foreach ($order->details as $item)
                                                <div class="detail-row">
                                                    <div class="detail-col"><h5>{{$item->menuRestaurant->nama_makanan}}</h5></div>
                                                    <div class="detail-col"><h5>{{$item->amount}}</h5></div>
                                                    <div class="detail-col"><h5>{{$item->sub_total}}</h5></div>
                                                </div>
                                                @endforeach

                                            </div>
                                                
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

    <script>
        $('.comments').each(function(i, obj) {
            if ($(obj).html() == "") {
                $(obj).html("-");
            }
        });

        $('.alamat').each(function(i, obj) {
            if ($(obj).html() == "") {
                $(obj).html("-");
            }
        });
    </script>

@endsection