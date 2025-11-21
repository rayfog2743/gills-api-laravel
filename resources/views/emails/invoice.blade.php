<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color:#222; }
        .header { display:flex; justify-content:space-between; align-items:center; }
        .company { text-align:left; }
        .qr { width:100px; }
        .table { width:100%; border-collapse: collapse; margin-top:20px; }
        .table th, .table td { border:1px solid #e6e6e6; padding:8px; text-align:left; }
        .right { text-align:right; }
        .totals { margin-top:20px; width:300px; float:right; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company">
            <h3>{{ config('app.name') }}</h3>
            <div>{{ $order->customer_name }}</div>
            <div>{{ $order->customer_phone }}</div>
            <div style="margin-top:8px;">{{ $order->address }}</div>
        </div>
        <div class="meta">
            <img src="{{ $qrPath }}" class="qr" alt="QR">
            <div>Order #: <strong>{{ $order->id }}</strong></div>
            <div>Status: <strong>{{ $order->status }}</strong></div>
            <div>Order Date: {{ \Carbon\Carbon::parse($order->order_time)->format('d-m-Y h:i A') }}</div>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Photo</th>
                <th>DESCRIPTION</th>
                <th>QTY</th>
                <th class="right">PRICE</th>
                <th class="right">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @php $items = is_string($order->items) ? json_decode($order->items, true) : $order->items; @endphp
            @foreach($items as $i => $it)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>
                        @if(!empty($it['image']))
                            <img src="{{ $it['image'] }}" style="width:60px;height:60px;object-fit:cover;">
                        @endif
                    </td>
                    <td>
                        {{ $it['name'] ?? 'Item' }}
                        <div style="font-size:10px;color:#666">SKU: {{ $it['sku'] ?? ($it['id'] ?? '') }}</div>
                    </td>
                    <td>{{ $it['quantity'] ?? ($it['qty'] ?? 1) }}</td>
                    <td class="right">₹{{ number_format(floatval($it['price_rupees'] ?? $it['price'] ?? 0),2) }}</td>
                    <td class="right">₹{{ number_format((floatval($it['price_rupees'] ?? $it['price'] ?? 0) * intval($it['quantity'] ?? ($it['qty'] ?? 1))),2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div>Sub Total : ₹{{ number_format($order->subtotal, 2) }}</div>
        <div>GST : ₹{{ number_format($order->gst_amount, 2) }}</div>
        <div>Shipping : ₹{{ number_format($order->shipping_charge ?? 0, 2) }}</div>
        <div style="font-weight:bold; margin-top:8px;">Total : ₹{{ number_format($order->total, 2) }}</div>
    </div>

    <div style="clear:both; margin-top:80px; font-size:11px; color:#666;">
        Thank you for your purchase.
    </div>
</body>
</html>
