<?php

namespace App\Actions\Order;

use App\User;
use App\Order;

class OrderUpdateAction
{
    /**
     * Process the order update action
     *
     * @param array $data
     * @return array
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
        } else {
            if (isset($data['status'])) {
                $order = Order::find($id);
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
                $flash = [
                    'type' => 'message-danger',
                    'message' => 'Order must have a status!'
                ];
            }

            return $flash;
        }
    }
}
