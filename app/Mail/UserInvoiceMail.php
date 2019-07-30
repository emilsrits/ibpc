<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Order;
use Barryvdh\DomPDF\PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public $user;

    public $pdf;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @param User $user
     */
    public function __construct(Order $order, User $user, PDF $pdf)
    {
        $this->order = $order;
        $this->user = $user;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.invoice')
                    ->subject('Invoice for order #' . $this->order->id)
                    ->attachData($this->pdf->output(), $this->order->id .'-invoice.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
