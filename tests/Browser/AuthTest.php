<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Login;
use Tests\Browser\Pages\Store;
use Tests\Browser\Pages\Register;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthTest extends DuskTestCase
{   
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'RolesTableSeeder']);
    }

    /** @test */
    public function user_can_register()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Register)
                ->type('@firstname', 'John')
                ->type('@lastname', 'Doe')
                ->type('@email', 'johndoe@example.test')
                ->type('@password', 'option123')
                ->type('@confirm', 'option123')
                ->press('Register')
                ->assertPathIs('/')
                ->assertSee('John')
                ->assertAuthenticated();
        });
    }

    /** @test */
    public function user_can_login()
    {
        $password = 'option123';
        $user = $this->createUser([
            'password' => bcrypt($password),
        ]);

        $this->browse(function (Browser $browser) use ($user, $password) {
            $browser->visit(new Login)
                ->type('@email', $user->email)
                ->type('@password', $password)
                ->press('Login')
                ->assertPathIs('/')
                ->assertSee($user->first_name)
                ->assertAuthenticated();
        });
    }

    /** @test */
    public function user_can_logout()
    {
        $user = $this->createUser();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit(new Store)
                ->assertPathIs('/')
                ->waitForText($user->first_name)
                ->assertSee($user->first_name)
                ->click('@dropdown')
                ->assertVisible('@sign-out')
                ->click('@sign-out')
                ->assertPathIs('/')
                ->assertGuest();
        });
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->browse(function (Browser $browser) {
            $browser->driver->manage()->deleteAllCookies();
        });
    }
}
