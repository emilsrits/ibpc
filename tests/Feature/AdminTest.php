<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        
        $this->artisan('db:seed', ['--class' => 'RolesTableSeeder']);
    }

    /** @test */
    public function admin_panel_requires_login()
    {
        $response = $this->get('/admin');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function admin_can_access_admin_panel()
    {
        $user = $this->createAdmin();

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(200);
    }

    /** @test */
    public function normal_user_can_not_access_admin_panel()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
}
