<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Register;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthTest extends DuskTestCase
{   
    use DatabaseMigrations;

    /** @test */
    public function user_can_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Register)
                ->type('@firstname', 'John')
                ->type('@lastname', 'Doe')
                ->type('@email', 'johndoe@example.com')
                ->type('@password', 'option123')
                ->type('@confirm', 'option123')
                ->press('Register')
                ->assertPathIs('/')
                ->assertSee('John')
                ->assertAuthenticated();
        });
    }
}
