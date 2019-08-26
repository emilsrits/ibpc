<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Events\OrderCreated;
use App\Events\InvoiceResent;
use App\Repositories\UserRepository;

class OrderService
{
    /**
     * Create a new service instance.
     * 
     * @param Order $order
     * @param UserRepository $userRepository
     */
    public function __construct(Order $order, UserRepository $userRepository)
    {
        $this->order = $order;
        $this->userRepository = $userRepository;
    }

    /**
     * Order mass action
     *
     * @param array $data
     * @return mixed
     */
    public function action(array $data)
    {
        if (isset($data['order'])) {
            $orderIds = $data['order'];
            $status = $data['mass-action'];

            if ($status) {
                $result = $this->order->setStatus($status, $orderIds);

                if ($result === false) {
                    flashMessage('message-danger', 'Can not change status of a finished order!');
                } else {
                    flashMessage('message-success', "Order(s) {$status} !");
                }

                return true;
            }

            return false;
        }
    }

    /**
     * Order store action
     *
     * @param $user
     * @param Cart $cart
     * @return mixed
     */
    public function store($user, Cart $cart)
    {
        if (!$user->canMakeOrder()) {
            flashMessage('message-warning', 'Please fill in missing shipping address information!');
            return false;
        }

        $order = new Order();
        $order->setUpOrder($cart, $user->id);
        $attached = $order->addItems($cart->items, $user->id);

        if ($attached === false) {
            flashMessage('message-danger', 'Not enough of products in stock!');
            return false;
        }

        event(new OrderCreated($order, $user));

        $cart->deleteCart();

        flashMessage('message-success', 'Order successfully placed!');

        return true;
    }

    /**
     * Order update action
     *
     * @param array $data
     * @param Order $order
     * @return mixed
     */
    public function update(array $data, Order $order)
    {
        if (isset($data['status'])) {
            $status = $data['status'];

            $statusSet = $order->setStatus($status);

            if ($statusSet === false) {
                flashMessage('message-danger', 'Can not change status of a finished order!');
                return false;
            } else {
                flashMessage('message-success', 'Order successfully updated!');
                return true;
            }
        } else {
            if (!orderStatusFinished($order->status)) {
                flashMessage('message-danger', 'Order must have a status!');
                return false;
            }
        }
    }

    /**
     * Order invoice action
     *
     * @param Order $order
     */
    public function invoice(Order $order)
    {
        $user = $this->userRepository->find($order->user->id);

        event(new InvoiceResent($order, $user));

        flashMessage('message-success', 'Invoice successfully sent!');
    }
}
