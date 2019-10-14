@extends('adminlte::master')

@section('adminlte_css')
    <style>
        .colmenu {
            padding: 8px;
        }

        .card {
            background-color: #fff;
            border: 1px solid #eee; 
            border-radius: 6px; 
        }

        .card .card-img img { 
            border-radius: 6px 6px 0 0; 
        }

        .card .card-img { 
            position: relative; 
            padding: 0; 
            display: table; 
        }

        .card .card-body {
            display: table; 
            width: 100%; 
            padding: 10px;
        }

        .card .card-body h5, .card .card-body h4 {
            text-transform: uppercase;
            margin: 0;
        }

        .card .card-body h5 {
            font-size: 12px;
            color: #3F7D20;
        }

        .card .card-body h4 {
            font-size: 15px;
            color: #3F7D20;
        }

        .card .card-body p {
            margin-top: 2px;
            margin-bottom: 12px;
        }

        .card .card-body .inline{
           display:  flex;
           justify-content: space-between;
        }

        .card .card-body .inline > *{
            display: inline-block;
        }

        .card .card-body .inline > *:nth-child(2) {
            float: right;
            width: 30%;
        }

        .card .card-body .inline button{
           background: #72B01D;
           font-weight: 400;
        }

        .card .card-body .inline .btn-number {
            background: #72B01D;
        }


        .preview-price {
            width: 60%;
            height: 50px;
            right: 0;
            left: 0;
            bottom: 0;
            position: fixed;
            left: 50%;
            margin-left: -30%;
            padding: 0 30px;
            background: #72B01D;
            border-radius: 6px; 
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .preview-price > * {
            display: inline-block;
            color: white;
        }

        .preview-price > *:nth-child(1), .preview-price > *:nth-child(2) {
            margin-top: 15.5px;
        }

        .preview-price > *:nth-child(3) {
            float: right;
            margin-top: 10px;
            background: transparent;
            border: 1px solid white;
        }

        .flex-item {
            display: flex;
            justify-content: space-between;
            width: 100%;
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

        .clear {
            background-color: white;
        }

        .space {
            height: 100px;
        }

        .modal-header {
            background: #72B01D;
        }

        @media only screen and (max-width: 480px) {
            .preview-price {
                width: 90%;
                margin-left: -45%;
            }

            .card .card-body .inline > *:nth-child(2) {
                float: right;
                width: auto;
            }

            .tambah-kurang {
                padding-left: 5px;
            }

            .tambah-kurang .input-group {
                width: auto !important;
            }

            .foto-kecil {
                margin: 0;
                margin-top: 15px;
            }

            #dynamicTable tr {
                align-items: center;
            }
        }

    </style>
@stop

@section('body')
    @include('layouts.nav')
    <div class="container">
        <div class="row">
        @foreach ($menuRestaurants as $menu)
            <div class="col-xs-6 col-sm-3 colmenu">
                <div class="card">
                    <span class="card-img">
                        <div class="menuimg">
                            <img src="{{Storage::url($menu->foto)}}" class="img-responsive" id="foto_{{$menu->id}}">
                        </div>
                        <div class="card-body">
                            <h5><b>{{$menu->kategori}}</b></h5>
                            <h4>{{$menu->nama_makanan}}</h4>
                            <p>{{$menu->deskripsi}}</p>

                            <div class="inline">
                                <b><p id="harga_{{$menu->id}}" data-harga="{{$menu->harga}}">{{$menu->harga}}</p></b>
                                <button class="btn btn-sm" id="tambah_{{$menu->id}}" onclick="pilihMenu({{$menu->id}}, '{{$menu->nama_makanan}}', {{$menu->harga}})">+ Add</button>
                                <div class="tambah-kurang" id="tambah_kurang_{{$menu->id}}" style="display: none;">
                                    <div class="input-group" style="width: 150px;">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default btn-number" data-type="minus" data-field="jumlah_{{$menu->id}}" id="__{{$menu->id}}">
                                                -
                                            </button>
                                        </span>
                                        <input type="text" name="jumlah_{{$menu->id}}" class="form-control input-number" value="1" min="1" max="10">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="jumlah_{{$menu->id}}">
                                                +
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <!-- <div class="btn-group">
                                    <button type="button" class="btn btn-sm" onclick="pilihMenu({{$menu->id}}, '{{$menu->nama_makanan}}', {{$menu->harga}})">-</button>
                                    <button class="btn btn-sm">0</button>
                                    <button type="button" class="btn btn-sm">+</button>
                                </div> -->
                            </div>
                        </div>
                    </span>
                </div>
            </div>

            <!-- <p>{{$menu->id}}</p>
            <p>{{$menu->nama}}</p>
            <p>{{$menu->deskripsi}}</p>
            <p>{{$menu->kategori}}</p>
            <p>{{$menu->harga}}</p>
            <p>{{$menu->stok}}</p>
            <p>{{$menu->foto}}</p>
            <p>{{$menu->restaurant->nama}}</p> -->
        @endforeach
        </div>

        <div class="row">
            <div class="space">
            </div>
        </div>

        <div class="preview-price">
            <h4><b>Total: </b> </h4>
            <h4 class="preview-total-price harga">0</h4>
            <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modal-cart"> 
            <i class="fa fa-fw fa-shopping-cart"> </i>View Cart</button>
        </div>

        <div class="modal fade" id="modal-cart" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Keranjang Pemesanan</h4>
                    </div>
                    
                    <form action={{route('user.order.final')}} method="POST" id="formOrder">
                    {{ csrf_field() }}
                        <div class="modal-body" style="padding-top: 0px; padding-bottom: 0px;">
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}" id="user_id"/>
                                <input type="hidden" name="restaurant_id" value="{{$id}}" id="restaurant_id"/>
                                
                                <div id="dynamicField"  style="display:none;"></div>

                                <table class="table table-condensed" id="dynamicTable">
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                                <input type="hidden" id="delivery" name="delivery" value="0"/>
                                <!-- <div style="display: flex;justify-content: space-between;">
                                    <div>
                                        <label for="comments">Notes : </label>
                                        <input type="text" name="comments" id="comments"/>
                                    </div>
                                    <div>
                                        <label for="comments">Take Food : </label>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="hehe">
                                                Pick Up
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" id="takefood">
                                                <li><a href="#" value="0">Pick Up</a></li>
                                                <li><a href="#" value="1">Delivery</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div id="add-alamat">
                                </div>  -->
                                <input type="hidden" name="total" id="total" value="0"/>
                                
                        </div>
                        <div class="modal-footer" style="padding-top: 0px;">
                            <div style="display: flex; justify-content: space-between;margin-top: 10px;margin-bottom: 10px;">
                                <h5><b>Total Harga Makanan : </b></h5>
                                <h5 class="preview-total-price">0</h5>
                            </div>
                            <div style="display: flex;justify-content: space-around;">
                                <button type="submit" class="btn btn-default" data-dismiss="modal" style="width: 100%;">Lihat Menu</button>
                                <button type="submit" class="btn btn-default" style="width: 100%; background: #72B01D;">Lanjut ke Pembayaran</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        

    </div>
@stop

@section('adminlte_js')
<script>
    $('#total').val(0)

    if($('#total').val() == 0) {
        $('#lanjut').attr("disabled", true);
    } else {
        $('#lanjut').attr("disabled", false);
    }
    
    let orderMenuId = []

    function pilihRestaurant(id){
        $('#restaurant_id').val(id);
    }

    function pilihMenu(id, nama, harga){
        if(orderMenuId.find(e => e == id) !== undefined){
            $('#menuId_'+id).val( parseInt($('#menuId_'+id).val()) + 1);
            $('#hargaMenuId_'+id).val( parseInt($('#menuId_'+id).val()) * harga)
            $('#total').val( parseInt($('#total').val()) + harga )

            $('.preview-total-price').text($('#total').val())

            // $('#tabletr_'+id+' > td:nth-child(2)').text($('#menuId_'+id).val())
            // $('#tabletr_'+id+' > td:nth-child(3)').text(parseInt($('#menuId_'+id).val()) * harga)

        } else {
            $('#tambah_'+id).css("display","none");
            $('#tambah_kurang_'+id).css("display","inline-block");
            orderMenuId.push(id);
            $('#dynamicField').append(
                "<br><input type='hidden' name='menu_restaurant_id[]' value='"+id+"' id='menuRestaurantId_"+id+"'/>"+ 
                "<input type='hidden' name='amount[]' value=1 id='menuId_"+id+"'/>"+
                "<input type='hidden' name='sub_total[]' value="+harga+" id='hargaMenuId_"+id+"'/>"+
                "<br>"
            )

            let foto = $('#foto_'+id).clone();
            foto.addClass('foto-kecil');

            $('#dynamicTable').append(
                "<tr id='tabletr_" +id + "' class='flex-item'><td style='display: flex;justify-content: space-between;'><div id='fotoo_"+id+"'></div><h5 style='margin-top: 15px;font-size: 14px !important;' >"+nama+"<div style='display: block;margin-top:10px;'>"+
                    "<div class='input-group' style='width: 150px;'><span class='input-group-btn'>"+
                        "<button type='button' class='btn btn-default btn-number btn-number"+id+"' data-type='minus' data-field='popupjumlah_"+id+"'>"+
                            "-"+
                        "</button>"+
                        "</span>"+
                        "<input type='text' name='popupjumlah_"+id+"' class='form-control input-number' value='1' min='1' max='10' id='asd"+id+"'>"+
                        "<span class='input-group-btn'>"+
                            "<button type='button' class='btn btn-default btn-number btn-number"+id+"' data-type='plus' data-field='popupjumlah_"+id+"'>"+
                                "+"+
                            "</button>"+
                        "</span>"+
                    "</div></h5>"+
                "</div></td>"+
                "<td style='margin: 20px;display:flex; align-items: center;'><div  id='hargaMenu_"+id+"'>" + harga + "</div><button type='button' onclick='hapusMenu("+id+","+harga+")' class='close' style='margin-left: 20px;margin-top: -2px;margin-right: -15px;'>&times;</button></td></tr>"
            )
            test(".btn-number"+id, "#asd"+id);

            $('#fotoo_'+id).html(foto);

            $('#total').val( parseInt($('#total').val()) + harga )

            $('.preview-total-price').text($('#total').val());

            if($('#total').val() == 0) {
                $('#lanjut').attr("disabled", true);
            } else {
                $('#lanjut').attr("disabled", false);
            }
        }
    }

    function hapusMenu(id, harga){
        orderMenuId.splice( orderMenuId.indexOf('id'), 1 );

        $('#menuRestaurantId_'+id).remove()
        $('#menuId_'+id).remove()
        $('#hargaMenuId_'+id).remove()
        $('#tabletr_'+id).remove()
        $('#total').val( parseInt($('#total').val()) - harga * parseInt($("input[name=jumlah_"+id+"]").val() - 1) )
        $('.preview-total-price').text($('#total').val());

        $("input[name=jumlah_"+id+"]").val(1);
        document.getElementById('__'+id).click();

    }


    //plugin bootstrap minus and plus
    //http://jsfiddle.net/laelitenetwork/puJ6G/
    $('.btn-number').click(function(e){
        e.preventDefault();
        
        fieldName = $(this).attr('data-field');
        type      = $(this).attr('data-type');
        var input = $("input[name='"+fieldName+"']");
        
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if(type == 'minus') {
                if(currentVal == 1){
                    let id = fieldName.substr(fieldName.indexOf('_')+1);
                    let harga = parseInt($('#harga_'+id).attr('data-harga'));
                    
                    orderMenuId.splice( orderMenuId.indexOf('id'), 1 );

                    $('#menuRestaurantId_'+id).remove()
                    $('#menuId_'+id).remove()
                    $('#hargaMenuId_'+id).remove()
                    $('#tabletr_'+id).remove()

                    $('#total').val( parseInt($('#total').val()) - harga )
                    $('.preview-total-price').text($('#total').val());

                    $('#tambah_'+id).css("display","block");
                    $('#tambah_kurang_'+id).css("display","none");
                }
                if(currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                    let id = fieldName.substr(fieldName.indexOf('_')+1);
                    let harga = parseInt($('#harga_'+id).attr('data-harga'));

                    $('#menuId_'+id).val( parseInt($('#menuId_'+id).val()) - 1);
                    $('#hargaMenuId_'+id).val( parseInt($('#menuId_'+id).val()) * harga)
                    $('#hargaMenu_'+id).html( parseInt($('#menuId_'+id).val()) * harga)
                    $('#total').val( parseInt($('#total').val()) - harga )
                    $("input[name=jumlah_"+id+"]").val(parseInt($('#menuId_'+id).val()))
                    $("input[name=popupjumlah_"+id+"]").val(parseInt($('#menuId_'+id).val()))

                    $('.preview-total-price').text($('#total').val())

                    // $('#tabletr_'+id+' > td:nth-child(2)').text($('#menuId_'+id).val())
                    // $('#tabletr_'+id+' > td:nth-child(3)').text(parseInt($('#menuId_'+id).val()) * harga)
                }
                // if(parseInt(input.val()) == input.attr('min')) {
                //     $(this).attr('disabled', true);
                // }

            } else if(type == 'plus') {

                if(currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                    let id = fieldName.substr(fieldName.indexOf('_')+1);
                    let harga = parseInt($('#harga_'+id).attr('data-harga'));
                    

                    $('#menuId_'+id).val( parseInt($('#menuId_'+id).val()) + 1);
                    $('#hargaMenuId_'+id).val( parseInt($('#menuId_'+id).val()) * harga)
                    $('#hargaMenu_'+id).html( parseInt($('#menuId_'+id).val()) * harga)
                    $('#total').val( parseInt($('#total').val()) + harga )

                    $("input[name=jumlah_"+id+"]").val(parseInt($('#menuId_'+id).val()))
                    $("input[name=popupjumlah_"+id+"]").val(parseInt($('#menuId_'+id).val()))

                    $('.preview-total-price').text($('#total').val())

                    // $('#tabletr_'+id+' > td:nth-child(2)').text($('#menuId_'+id).val())
                    // $('#tabletr_'+id+' > td:nth-child(3)').text(parseInt($('#menuId_'+id).val()) * harga)
                }
                if(parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });
    $('.input-number').focusin(function(){
        $(this).data('oldValue', $(this).val());
        });
    $('.input-number').change(function() {
        
        minValue =  parseInt($(this).attr('min'));
        maxValue =  parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());
        
        name = $(this).attr('name');
        if(valueCurrent >= minValue -1) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        
        
    });
    $(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });



    function test(id,id2){
        console.log(id);
        $(id).click(function(e){
        e.preventDefault();
        
        fieldName = $(this).attr('data-field');
        type      = $(this).attr('data-type');
        var input = $("input[name='"+fieldName+"']");

        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if(type == 'minus') {
                if(currentVal == 1){
                    let id = fieldName.substr(fieldName.indexOf('_')+1);
                    let harga = parseInt($('#harga_'+id).attr('data-harga'));
                    
                    orderMenuId.splice( orderMenuId.indexOf('id'), 1 );

                    $('#menuRestaurantId_'+id).remove()
                    $('#menuId_'+id).remove()
                    $('#hargaMenuId_'+id).remove()
                    $('#tabletr_'+id).remove()

                    $('#total').val( parseInt($('#total').val()) - harga )
                    $('.preview-total-price').text($('#total').val());

                    $('#tambah_'+id).css("display","block");
                    $('#tambah_kurang_'+id).css("display","none");
                }
                if(currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                    let id = fieldName.substr(fieldName.indexOf('_')+1);
                    let harga = parseInt($('#harga_'+id).attr('data-harga'));

                    $('#menuId_'+id).val( parseInt($('#menuId_'+id).val()) - 1);
                    $('#hargaMenuId_'+id).val( parseInt($('#menuId_'+id).val()) * harga)
                    $('#hargaMenu_'+id).html( parseInt($('#menuId_'+id).val()) * harga)
                    $('#total').val( parseInt($('#total').val()) - harga )
                    $("input[name=jumlah_"+id+"]").val(parseInt($('#menuId_'+id).val()))
                    $("input[name=popupjumlah_"+id+"]").val(parseInt($('#menuId_'+id).val()))

                    $('.preview-total-price').text($('#total').val())

                    // $('#tabletr_'+id+' > td:nth-child(2)').text($('#menuId_'+id).val())
                    // $('#tabletr_'+id+' > td:nth-child(3)').text(parseInt($('#menuId_'+id).val()) * harga)
                }
                // if(parseInt(input.val()) == input.attr('min')) {
                //     $(this).attr('disabled', true);
                // }

            } else if(type == 'plus') {

                if(currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                    let id = fieldName.substr(fieldName.indexOf('_')+1);
                    let harga = parseInt($('#harga_'+id).attr('data-harga'));

                    $('#menuId_'+id).val( parseInt($('#menuId_'+id).val()) + 1);
                    $('#hargaMenuId_'+id).val( parseInt($('#menuId_'+id).val()) * harga)
                    $('#hargaMenu_'+id).html( parseInt($('#menuId_'+id).val()) * harga)
                    $('#total').val( parseInt($('#total').val()) + harga )
                    
                    $("input[name=jumlah_"+id+"]").val(parseInt($('#menuId_'+id).val()))
                    $("input[name=popupjumlah_"+id+"]").val(parseInt($('#menuId_'+id).val()))

                    $('.preview-total-price').text($('#total').val())

                    // $('#tabletr_'+id+' > td:nth-child(2)').text($('#menuId_'+id).val())
                    // $('#tabletr_'+id+' > td:nth-child(3)').text(parseInt($('#menuId_'+id).val()) * harga)
                }
                if(parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });
    $(id2).focusin(function(){
        $(this).data('oldValue', $(this).val());
        });
    $('.input-number').change(function() {
        
        minValue =  parseInt($(this).attr('min'));
        maxValue =  parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());
        
        name = $(this).attr('name');
        if(valueCurrent >= minValue -1) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        
        
    });
    $(id2).keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    }
</script>
@stop
