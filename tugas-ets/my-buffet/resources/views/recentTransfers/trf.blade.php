<form action={{route('api.transfered',$order->id)}} method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="order_id" value="{{$order->id}}">
    <input type="hidden" name="total" value="{{$order->total}}">
    <button type="submit"> Transfer </button>
</form>