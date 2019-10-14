@extends('adminlte::master')

@section('adminlte_css')
    <style>
        h3{
            font-weight: 500;   
        }

        tr > td {
            border-top: none !important;
        }

        .foto-kecil {
            height: 60px;
            width: 60px;
            margin: 15px;
        }

        .input-group > input{
            text-align: center;
        }

        #dynamicTable > tbody > tr {
            border-bottom: 1px solid #f0f0f0;
        }

        #dynamicTable {
            margin-bottom: 0px;
        }

        .panel-title {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .form-control:not(select) {
            -moz-appearance: button;
        }

        .bank {
            width: 102px;
            height: 30px;
        }

        p{
            line-height: 15px;
            font-size: 15px;
        }

        .clear {
            background-color: white;
        }

    </style>
@stop

@section('body')
    @include('layouts.nav')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background: #72B01D">
                        <h3 class="panel-title" style="color: #0D0A0B">Pembayaran</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12 text-center"> 
                            <div class="btn-group btn-group-lg" role="group" aria-label="Large button group" id="x"> 
                                <button type="button" onclick="tampil(1,this)" class="btn"><img class="bank" src="http://www.bni.co.id/Portals/1/bni-logo-id.svg?ver=2017-04-27-170938-000"></button> 
                                <button type="button" onclick="tampil(2,this)" class="btn"><img class="bank" src="https://upload.wikimedia.org/wikipedia/id/thumb/e/e0/BCA_logo.svg/1280px-BCA_logo.svg.png"></button> 
                                <button type="button" onclick="tampil(3,this)" class="btn"><img class="bank" src="https://upload.wikimedia.org/wikipedia/id/thumb/f/fa/Bank_Mandiri_logo.svg/1280px-Bank_Mandiri_logo.svg.png"></button> 
                                <button type="button" onclick="tampil(4,this)" class="btn"><img class="bank" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/BANK_BRI_logo.svg/1280px-BANK_BRI_logo.svg.png"></button> 
                                <button type="button" onclick="tampil(5,this)" class="btn"><img class="bank" src="https://upload.wikimedia.org/wikipedia/id/thumb/4/48/PermataBank_logo.svg/1280px-PermataBank_logo.svg.png"></button> 

                            </div>
                        </div>
                        <div class="col-md-12"> 
                            <div class="panel-footer" style="display: none" id="1">
                                <p>1. Login ke akun BNI Mobile</p>
                                <p>2. Pilih Transfer > Virtual Account Billing</p>
                                <p>3. Masukkan angka 42398 diikuti nomor HP-mu (mis.: 42398xxx xxxxx xxxx)</p>
                                <p>4. Masukkan {{$order->total}}</p>
                                <p>5. Ikuti instruksi untuk menyelesaikan transaksi</p>
                            </div>
                            <div class="panel-footer" style="display: none" id="2">
                                <p>1. Login ke akun BCA Mobile</p>
                                <p>2. Pilih Transaksi Lainnya > Transfer > Virtual Account</p>
                                <p>3. Masukkan angka 33143 diikuti nomor HP-mu (mis.: 33143xxx xxxxx xxxx)</p>
                                <p>4. Masukkan {{$order->total}}</p>
                                <p>5. Ikuti instruksi untuk menyelesaikan transaksi</p>
                            </div>
                            <div class="panel-footer" style="display: none" id="3">
                                <p>1. Login ke akun Mandiri Mobile</p>
                                <p>2. Pilih Bayar/Beli > Lainnya > Lainya > Transfer > Virtual Account</p>
                                <p>3. Masukkan angka 61234 diikuti nomor HP-mu (mis.: 61234xxx xxxxx xxxx)</p>
                                <p>4. Masukkan {{$order->total}}</p>
                                <p>5. Ikuti instruksi untuk menyelesaikan transaksi</p>
                            </div>
                            <div class="panel-footer" style="display: none" id="4">
                                <p>1. Login ke akun Bri Mobile</p>
                                <p>2. Pilih Transfer > Transfer ke Bank Lain > Bank Nobu (Biaya admin 6500)</p>
                                <p>3. Masukkan angka 9 diikuti nomor HP-mu (mis.: 9xxx xxxxx xxxx)</p>
                                <p>4. Masukkan {{$order->total}}</p>
                                <p>5. Ikuti instruksi untuk menyelesaikan transaksi</p>
                            </div>
                            <div class="panel-footer" style="display: none" id="5">
                                <p>1. Login ke akun Permata Mobile Net</p>
                                <p>2. Pilih Transfer > Transfer ke Virtual Account </p>
                                <p>3. Masukkan angka 91 diikuti nomor HP-mu (mis.: 91xxx xxxxx xxxx)</p>
                                <p>4. Masukkan {{$order->total}}</p>
                                <p>5. Konfirmasi Detail dan masukkan Response Code</p>
                                <p>6. Ikuti instruksi untuk menyelesaikan transaksi</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" style="background: #72B01D">
                        <h3 class="panel-title" style="color: #0D0A0B">Order</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{route('user.order.bayarr',$order->id)}}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <input type="hidden" id="delivery" name="delivery" value="{{$order->delivery}}"/>
                            <input type="hidden" id="status" name="status" value="1"/>
                            <div class="col-md-2">
                                <label for="comments">Take Food</label>
                            </div>
                            <div class="col-md-10">
                                <div class="btn-group" style="margin-bottom: 13px;">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="hehe">
                                        @if ($order->delivery == 0)
                                            Pick Up    
                                        @else
                                            Delivery
                                        @endif
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" id="takefood">
                                        <li><a href="#" value="0">Pick Up</a></li>
                                        <li><a href="#" value="1">Delivery</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="add-alamat">
                            
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="comments">Notes</label>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <textarea name="comments" id="comments" class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center"> 
                            <button type="submit" class="btn btn-default" style="width: 50%; background: #72B01D; color: #0D0A0B" >Order</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background: #72B01D"> 
                        <h3 class="panel-title" style="color: #0D0A0B">Detail Order</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-condensed" id="dynamicTable">
                            <tbody>
                                @foreach ($order->details as $item)
                                    <tr class="flex-item">
                                        <td style="display: flex;justify-content: space-between;">
                                            <h5 style="margin-top: 15px;font-size: 14px !important;">{{$item->menuRestaurant->nama_makanan}} <i class="fa fa-times" aria-hidden="true"></i> {{$item->amount}}</h5>
                                        </td>
                                        <td>
                                            <h5 style="margin-top: 15px;font-size: 14px !important;text-align: right;">{{$item->sub_total}}</h5>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer">
                        <div style="display: flex; justify-content: space-between;">
                            <h5><b>Total Harga Makanan : </b></h5>
                            <h5 class="preview-total-price">{{$order->total}}</h5>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
        
@stop

@section('adminlte_js')
<script>
    function tampil(id, e){
        $('button.btn').removeClass('clear');
        $('#1').css('display','none');
        $('#2').css('display','none');
        $('#3').css('display','none');
        $('#4').css('display','none');
        $('#5').css('display','none');
        $('#'+id).css('display','block');
        $(e).addClass('clear');
    }
    
    $( document ).ready(function() {
        console.log($('#delivery').val())
        if($('#delivery').val() == 1){
            $('#add-alamat').html("<div class='col-md-2'><label for='comments'>Alamat</label></div><div class='col-md-10'><div class='form-group'><input type='text' class='form-control' name='alamat' id='alamat'/></div></div>")
        }
    });

    $("#takefood a").click(function(){
        $(this).parents(".btn-group").find('#hehe').text($(this).text());
        $('#delivery').val(parseInt($(this).attr('value')));
        $("#add-alamat").empty();
        if($('#delivery').val() == 1){
            $('#add-alamat').html("<div class='col-md-2'><label for='comments'>Alamat</label></div><div class='col-md-10'><div class='form-group'><input type='text' class='form-control' name='alamat' id='alamat'/></div></div>")
        }
    });
</script>
@stop
