<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $pdfData;

    public function __construct($order, $pdfData)
    {
        $this->order = $order;
        $this->pdfData = $pdfData;
    }

    public function build()
    {
        $filename = "invoice_{$this->order->id}.pdf";

        return $this->subject("Invoice for Order #{$this->order->id}")
                    ->view('emails.invoice_plain')
                    ->attachData($this->pdfData, $filename, [
                        'mime' => 'application/pdf',
                    ]);
    }
}
