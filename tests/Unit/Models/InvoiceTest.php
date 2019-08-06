<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Events\OrderCreated;
use App\Mail\UserInvoiceMail;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'RolesTableSeeder']);
    }

    /** @test */
    public function it_can_send_mail()
    {
        $user = $this->createUser();
        $order = $this->createOrder($user);

        Mail::fake();

        event(new OrderCreated($order, $user));

        Mail::assertSent(UserInvoiceMail::class, function ($mail) use ($user) { 
            return $mail->user->id == $user->id; 
        });
    }
}
