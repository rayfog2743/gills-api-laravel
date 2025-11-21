<?php

namespace App\Jobs;

use App\Mail\InvoiceMail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SendInvoiceEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $orderId;
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = Order::find($this->orderId);

        if (! $order) {
            Log::warning("SendInvoiceEmailJob: order not found", ['order_id' => $this->orderId]);
            return;
        }

        try {
            // Prepare QR path (embed as data URI) if exists
            $qrPath = null;
            if (Storage::disk('public')->exists("qrcodes/q_{$order->id}.png")) {
                $full = Storage::disk('public')->path("qrcodes/q_{$order->id}.png");
                $type = pathinfo($full, PATHINFO_EXTENSION);
                $data = file_get_contents($full);
                $qrPath = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }

            // Render Blade to PDF (generate inside job)
            $pdf = PDF::loadView('emails.invoice', [
                'order' => $order,
                'qrPath' => $qrPath,
            ])->setPaper('a4', 'portrait');

            $pdfData = $pdf->output();
            //  $toEmail = User::where('id',$order->user_id)->get('email');
               $toEmail = User::where('id',$order->user_id)->get('email');
            // Option 1: send email sync inside job (recommended)
            // $toEmail = $order->customer_email ?? config('mail.from.address'); // fallback
            // $toEmail = "sk.asif0490@gmail.com";
            if (! $toEmail) {
                // optionally save PDF to storage
                Storage::disk('local')->put("invoices/invoice_{$order->id}.pdf", $pdfData);
                Log::warning("Invoice not emailed: no email address for order {$order->id}");
                return;
            }

           
            // Build mailable (InvoiceMail should NOT implement ShouldQueue)
            Mail::to($toEmail)->send(new InvoiceMail($order, $pdfData));

            // Optionally store copy on disk
            Storage::disk('local')->put("invoices/invoice_{$order->id}.pdf", $pdfData);

            Log::info("Invoice email sent for order", ['order_id' => $order->id, 'to' => $toEmail]);
        } catch (\Exception $e) {
            Log::error('SendInvoiceEmailJob error', [
                'order_id' => $this->orderId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            // Let the job fail / be retried according to queue config
            throw $e;
        }
    }
}
