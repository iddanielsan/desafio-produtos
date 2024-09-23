<x-mail::message>
# Introduction

Olá {{ $order->customer->user->name }}, o seu pedido foi criado com sucesso, aqui está o resumo do seu pedido:

@foreach($order->products as $product)
- {{ $product->name }} x {{ $product->pivot->quantity }}
@endforeach

Total: R$ {{ number_format($order->total, 2, ',', '.') }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
