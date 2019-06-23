<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Actions\User\UserActionAction;
use App\Actions\User\UserUpdateAction;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\User\UserActionRequest;
use App\Filters\UserFilter;

class UserController extends Controller
{
	protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Return users list view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::with('roles')->orderBy('id', 'Asc')->paginate(20);

        return view('admin.user.users', ['users' => $users, 'request' => null]);
    }

    /**
     * Users mass action
     *
     * @param \App\Http\Requests\User\UserActionRequest $request
     * @param \App\Actions\User\UserActionAction $action
     * @param UserFilter $filters
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(UserActionRequest $request, UserActionAction $action, UserFilter $filters)
    {
        $flash = $action->execute($request->all());
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
        }

        $users = User::with('roles')->filter($filters)->paginate(20);

        return view('admin.user.users', ['users' => $users, 'request' => $request ]);
    }

    /**
     * Return user edit page
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::with('roles')->find($id);
        $roles = Role::all();

        return view('admin.user.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update user
     *
     * @param \App\Http\Requests\User\UserUpdateRequest $request
     * @param \App\Actions\User\UserUpdateAction $action
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, UserUpdateAction $action, $id)
    {
        $flash = $action->execute($request->all(), $id);
        $request->session()->flash($flash['type'], $flash['message']);
        
        return redirect()->back();
    }

    /**
     * Delete user
     *
     * @param string $id
     */
    public function delete($id)
    {
        $user = new User();
        $user->deleteUser($id);
    }
}
