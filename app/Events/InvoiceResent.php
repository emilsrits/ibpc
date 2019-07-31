<?php

namespace App\Events;

use App\Models\User;
use App\Models\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class InvoiceResent
{
    use Dispatchable, SerializesModels;

    /**
     * @var Order
     */
    public $order;
    
    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     * @param Order $order
     * @return void
     */
    public function __construct(Order $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }
}
