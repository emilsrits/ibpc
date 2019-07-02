<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class Register extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/user/register';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@firstname' => 'input[name=first_name]',
            '@lastname' => 'input[name=last_name]',
            '@email' => 'input[name=email]',
            '@password' => 'input[name=password]',
            '@confirm' => 'input[name=password_confirmation]',
        ];
    }
}
