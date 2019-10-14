@extends('adminlte::master')

@section('adminlte_css')
    <style>
        .placed {
            color: #72B01D !important;
            font-size: 80px;
        }

        .panel-heading {
            background-color: white !important;
        }

        p {
            font-size: 20px;
        }

        .container {
            margin-top: 10px;
        }

        button a{
            color: white !important;
        }

        .bank {
            width: 102px;
            height: 30px;
        }

        .panel-footer p{
            text-align: left;   
        }

        .panel-footer {
            margin-right: 17%;
            margin-left: 17%;
        }

        .clear {
            background-color: white;
        }

        @media only screen and (max-width: 480px) {
            .panel-body {
                padding: 20px 0 0 0;
            }

            .panel-footer {
                margin: auto;
                margin-top: 20px;
            }

            .button-home {
                width: 50% !important;
                margin-top: 10px;
                margin-bottom: 10px;
            }
        }

    </style>
@stop

@section('body')
    @include('layouts.nav')
    <div class="container">
        <div class="col-md-12 text-center">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="glyphicon glyphicon-ok-circle placed"></i><br><h2>Order Telah Diterima !</h2></div>
                <div class="panel-body">
                    <p>Setelah kamu transfer, pesanan kamu akan jadi dalam ~30 menit!</p>
                    

                    <div class="panel-body">
                            <div class="col-md-12 text-center"> 
                                <div class="btn-group btn-group-lg" role="group" aria-label="Large button group"> 
                                    <button type="button" onclick="tampil(1,this)" class="btn clear"><img class="bank" src="http://www.bni.co.id/Portals/1/bni-logo-id.svg?ver=2017-04-27-170938-000"></button> 
                                    <button type="button" onclick="tampil(2,this)" class="btn"><img class="bank" src="https://upload.wikimedia.org/wikipedia/id/thumb/e/e0/BCA_logo.svg/1280px-BCA_logo.svg.png"></button> 
                                    <button type="button" onclick="tampil(3,this)" class="btn"><img class="bank" src="https://upload.wikimedia.org/wikipedia/id/thumb/f/fa/Bank_Mandiri_logo.svg/1280px-Bank_Mandiri_logo.svg.png"></button> 
                                    <button type="button" onclick="tampil(4,this)" class="btn"><img class="bank" src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/BANK_BRI_logo.svg/1280px-BANK_BRI_logo.svg.png"></button> 
                                    <button type="button" onclick="tampil(5,this)" class="btn"><img class="bank" src="https://upload.wikimedia.org/wikipedia/id/thumb/4/48/PermataBank_logo.svg/1280px-PermataBank_logo.svg.png"></button> 
    
                                </div>
                            </div>
                            <div class="col-md-12 text-center"> 
                                <div class="panel-footer" style="display: block" id="1">
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

                        <div class="col-md-12 text-center"> 
                            <a href="{{route('user.home')}}">
                                <button type="submit" class="btn btn-default button-home" style="width: 15%; background: #72B01D; color: #0D0A0B">
                                    Home
                                </button>
                            </a>
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
</script>
@stop
