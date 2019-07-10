<?php

namespace App\Actions\Order;

use App\Models\Order;

class OrderActionAction
{
    /**
     * Process the order mass-action action
     *
     * @param array $data
     * @return mixed
     */
    public function execute(array $data)
    {
        if (isset($data['orders'])) {
            $orderIds = $data['orders'];
            $status = $data['mass-action'];

            if ($status) {
                $order = new Order();
                $result = $order->setStatus($orderIds, $status);

                if ($result === false) {
                    $flash = [
                        'type' => 'message-danger',
                        'message' => 'Can not change status of a finished order!'
                    ];
                } else {
                    $flash = [
                        'type' => 'message-success',
                        'message' => 'Order(s) ' . $status . '!'
                    ];
                }
                
                return $flash;
            }
        }
        
        return;
    }
}
