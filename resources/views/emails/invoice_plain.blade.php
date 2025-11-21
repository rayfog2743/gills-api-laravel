<p>Hi {{ $order->customer_name }},</p>
<p>Thank you for your order. Please find your invoice attached (Order #{{ $order->id }}).</p>
<p>Regards,<br>{{ config('app.name') }}</p>
