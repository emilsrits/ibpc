<?php

namespace App\Actions\Order;

use App\Models\User;
use App\Models\Order;

class OrderUpdateAction
{
    /**
     * Process the order update action
     *
     * @param array $data
     * @return array|null
     */
    public function execute(array $data, $id)
    {
        // If action is to send invoice, else update order
        if ($data['submit'] === 'invoice') {
            $order = Order::with('user')->find($id);
            $user = User::find($order->user->id);

            if ($order->status === config('constants.order_status.pending')) {
                $order->status = config('constants.order_status.invoiced');
            }
            $user->invoice($user, $order);

            $order->save();

            $flash = [
                'type' => 'message-success',
                'message' => 'Invoice successfully sent!'
            ];

            return $flash;
        } 
        
        if ($data['submit'] === 'save') {
            $order = Order::find($id);

            if (isset($data['status'])) {
                $status = $data['status'];

                $result = $order->setStatus($id, $status);

                if ($result === false) {
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
