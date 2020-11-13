<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $pdf;
    public $data;
    public function __construct($pdf_data,$data)
    {
        //
        $this->pdf = $pdf_data;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Customerpay.me Payment Receipt')
        ->view('emails.receipt')->attachData($this->pdf, 'payment_receipt.pdf', [
            'mime' => 'application/pdf',
        ]);
    }
}
