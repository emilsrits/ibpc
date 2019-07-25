<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Filters\UserFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('db:seed', ['--class' => 'RolesTableSeeder']);
        
        $this->user = $this->createUser();
    }

    /** @test */
    public function it_can_create_user()
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe.example@example.test',
            'password' => Hash::make('option123'),
        ];
        $user = User::create($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($data['first_name'], $user->first_name);
        $this->assertEquals($data['last_name'], $user->last_name);
        $this->assertEquals($data['email'], $user->email);
    }

    /** @test */
    public function it_can_show_user()
    {
        $found = User::find($this->user->id);

        $this->assertInstanceOf(User::class, $found);
        $this->assertEquals($found->first_name, $this->user->first_name);
        $this->assertEquals($found->last_name, $this->user->last_name);
        $this->assertEquals($found->email, $this->user->email);
    }

    /** @test */
    public function it_can_update_user()
    {
        $data = [
            'first_name' => 'Lorem',
            'last_name' => 'Ipsum',
            'email' => 'lorem.ipsum@example.test',
            'password' => Hash::make('password'),
        ];

        $updated = $this->user->update($data);

        $this->assertTrue($updated);
        $this->assertEquals($data['first_name'], $this->user->first_name);
        $this->assertEquals($data['last_name'], $this->user->last_name);
        $this->assertEquals($data['email'], $this->user->email);
        $this->assertEquals($data['password'], $this->user->password);
    }

    /** @test */
    public function it_can_delete_user()
    {
        $user = $this->createUser();

        $deleted = $user->delete();

        $this->assertTrue($deleted);
    }

    /** @test */
    public function it_can_assign_role_to_user()
    {
        $this->user->assignRole('admin');

        $this->assertTrue($this->user->hasRole('admin'));
    }

    /** @test */
    public function it_can_update_user_roles()
    {
        $this->user->updateRoles([Role::ROLE_ADMIN]);

        $this->assertFalse($this->user->hasRole('user'));
        $this->assertTrue($this->user->hasRole('admin'));
    }

    /** @test */
    public function it_can_filter_by_name()
    {
        $this->createUser([
            'last_name' => 'Orange',
        ]);
        $this->createUser([
            'first_name' => 'Ranger',
        ]);

        $request = Request::create('/users', 'POST', [
            'user' => 'ange'
        ]);
        $filter = new UserFilter($request);
        $users = User::filter($filter)->get();

        $this->assertEquals(true, count($users) >= 2);
    }

    /** @test */
    public function it_can_filter_by_role()
    {
        $this->createAdmin([], 3);

        $request = Request::create('/users', 'POST', [
            'role' => Role::ROLE_ADMIN
        ]);
        $filter = new UserFilter($request);
        $users = User::filter($filter)->get();

        $this->assertEquals(true, count($users) >= 3);
    }

    /** @test */
    public function it_can_filter_by_status()
    {
        $this->createUser([
            'status' => User::USER_DISABLED
        ], 3);

        $reqest = Request::create('/users', 'POST', [
            'status' => User::USER_DISABLED
        ]);
        $filter = new UserFilter($reqest);
        $users = User::filter($filter)->get();

        $this->assertEquals(true, count($users) >= 3);
    }
}
