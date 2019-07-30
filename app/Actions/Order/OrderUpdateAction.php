<?php

namespace App\Actions\Order;

use App\Models\User;
use App\Models\Order;
use App\Events\InvoiceResent;

class OrderUpdateAction
{
    /**
     * Process the order update action
     *
     * @param array $data
     * @param Order $order
     * @return mixed
     */
    public function execute(array $data, $order)
    {
        // If action is to send invoice, else update order
        if ($data['submit'] === 'invoice') {
            $user = User::find($order->user->id);

            event(new InvoiceResent($order, $user));

            $flash = [
                'type' => 'message-success',
                'message' => 'Invoice successfully sent!'
            ];

            return $flash;
        } 
        
        if ($data['submit'] === 'save') {
            if (isset($data['status'])) {
                $status = $data['status'];

                $statusSet = $order->setStatus($status);

                if ($statusSet === false) {
                    $flash = [
                        'type' => 'message-danger',
                        'message' => 'Can not change status of a finished order!'
                    ];
                } else {
                    $flash = [
                        'type' => 'message-success',
                        'message' => 'Order successfully updated!'
                    ];
                }
            } else {
                if (!orderStatusFinished($order->status)) {
                    $flash = [
                        'type' => 'message-danger',
                        'message' => 'Order must have a status!'
                    ];
                } else {
                    $flash = null;
                }
            }

            return $flash;
        }

        $flash = [
            'type' => 'message-danger',
            'message' => 'Invalid form action!'
        ];

        return $flash;
    }
}
