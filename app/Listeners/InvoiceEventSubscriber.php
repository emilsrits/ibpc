<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserInvoiceMail;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

class InvoiceEventSubscriber 
{
    /**
     * Handle order created event
     *
     * @param $event
     */
    public function onOrderCreated($event) {
        $save = config('constants.invoice_storage');

        $this->sendInvoice($event->order, $event->user, $save);
    }

    /**
     * Handle invoice resent event
     *
     * @param $event
     */
    public function onInvoiceResent($event) {
        $this->resendInvoice($event->order, $event->user);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\OrderCreated',
            'App\Listeners\InvoiceEventSubscriber@onOrderCreated'
        );

        $events->listen(
            'App\Events\InvoiceResent',
            'App\Listeners\InvoiceEventSubscriber@onInvoiceResent'
        );
    }

    /**
     * Create invoice file and send email to user about the order
     *
     * @param $order
     * @param $user
     * @param bool $save
     */
    private function sendInvoice($order, $user, $save = false)
    {
        // Generate PDF invoice file
        $pdf = PDF::loadView('pdf.invoice', ['user' => $user, 'order' => $order]);

        // Send mail with order info and attached invoice
        try {
            Mail::to($user->email)->send(
                new UserInvoiceMail($order, $user, $pdf)
            );

            if ($order->status === config('constants.order_status.pending')) {
                $order->status = config('constants.order_status.invoiced');
            }
        } catch(\Exception $e) {
            $order->status = config('constants.order_status.canceled');
            report($e);
        }

        $order->save();

        // Save copy of invoice locally
        if ($save) {
            $now = Carbon::now();
            Storage::put("orders/{$now->year}/{$now->month}/{$order->id}-invoice-" . str_random(2) . ".pdf", $pdf->output());
        }
    }

    /**
     * Resend email to the user with invoice file attached
     *
     * @param $order
     * @param $user
     */
    private function resendInvoice($order, $user)
    {
        // Generate PDF invoice file
        $pdf = PDF::loadView('pdf.invoice', ['user' => $user, 'order' => $order]);

        // Send mail with order info and attached invoice
        try {
            Mail::to($user->email)->send(
                new UserInvoiceMail($order, $user, $pdf)
            );

            if ($order->status === config('constants.order_status.pending')) {
                $order->status = config('constants.order_status.invoiced');
            }
        } catch(\Exception $e) {
            report($e);
        }

        $order->save();
    }
}
