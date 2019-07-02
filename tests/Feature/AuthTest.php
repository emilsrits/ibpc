<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_register()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    /** @test */
    public function user_gets_registered_with_correct_data()
    {
        $user = $this->makeUserWithNoRole();

        $response = $this->post('/register', [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/');

        $this->assertAuthenticated();
    }

    /** @test */
    public function user_does_not_get_registered_with_invalid_data()
    {
        $user = $this->makeUserWithNoRole();

        $response = $this->post('/register', [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'invalid'
        ]);
        $response->assertSessionHasErrors();

        $this->assertGuest();
    }

    /** @test */
    public function user_can_view_login()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_login_with_correct_data()
    {
        $user = $this->createUser([
            'password' => bcrypt($password = 'password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);
        $response->assertStatus(302);
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_can_not_login_with_incorrect_data()
    {
        $user = $this->createUser([
            'password' => bcrypt('password'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid'
        ]);
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }

    /** @test */
    public function user_can_not_view_login_while_logged_in()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/');
    }

    /** @test */
    public function user_can_logout_while_logged_in()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->post('/logout');
        $response->assertRedirect('/');

        $this->assertGuest();
    }
}
