@extends('layouts.admin')

@section('title', 'Entregadores')

@section('content')
<style>
    .active {
        display: block !important;
    }
</style>
<section class="motoboy ">
    <?php $i = 0; ?>
    <h3>Entregador:</h3>
    <select name="entregadores-select" id="entregadores-select">
        @foreach($list as $ent)
        <option value="{{ $ent->id }}">{{ $ent->name }} - {{ $ent->getLoja->nome_loja }}</option>
        @endforeach
    </select>
    @foreach($deliveryMans as $man)
    <div class="row @if($i == 0) active @endif" @if($i> 0) style="display: none;" @endif id="{{ $man->id }}">
        <div class="col-md-6">
            <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ $man->lat }},{{ $man->lng }}&zoom=14&size=500x400&markers=color:0x800b58%7Clabel:E%7C{{ $man->lat }},{{ $man->lng }}&key={{ env('MAPS_KEY') }}" width="100%" height="400" style="border:0"></iframe>
            <p>Última atualização do mapa às:<strong> {{ \Carbon\Carbon::parse($man->updated_at)->format('H:i') }}</strong></p>
        </div>
        <div class="col-md-5 list-content">
            <div class="list-info-title">
                <p>ID</p>
                <p>Saída</p>
                <p>Chegada</p>
                <p>Status</p>
            </div>
            @if($man->getDeliveryManOrders->count() > 0)
            @foreach($man->getDeliveryManOrders as $order)
            <div class="list-info">
                <p>#<strong>{{ $order->id }}</strong></p>
                <p>{{ \Carbon\Carbon::parse($order->created_at)->format('H:i') }}</p>
                <p>{{ \Carbon\Carbon::parse($order->order_dev_time)->format('H:i') }}</p>
                <p>{{ $order->getStatus->status_name }}</p>
            </div>
            @endforeach
            @else
            <div>
                <p style="text-align: center;">Não há pedidos para esse entregador</p>
            </div>
            @endif
        </div>
    </div>
    <?php $i++; ?>
    @endforeach
</section>
@endsection
@section('js')
<script>
    $('#entregadores-select').change(function() {

        var id = $('#entregadores-select option:selected').val(),
            active = $('.active');

        $(active).removeClass('active');
        $(active).css('display', 'none');
        $('.row[id="' + id + '"]').addClass('active');

    });
</script>
@endsection