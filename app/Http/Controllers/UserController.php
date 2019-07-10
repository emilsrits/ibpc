<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Actions\User\UserActionAction;
use App\Actions\User\UserUpdateAction;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\User\UserActionRequest;
use App\Filters\UserFilter;

class UserController extends Controller
{
	protected $redirectTo = '/';

    /**
     * UserController constructor
     *
     * @param User $user
     * @param Role $role
     */
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Return users list view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.user.users', [
            'users' => $this->user->with('roles')->oldest('id')->paginate(20), 
            'request' => null
        ]);
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
        $flash = $action->execute($request->validated());
        if ($flash != null) {
            $request->session()->flash($flash['type'], $flash['message']);
        }

        $users = $this->user->with('roles')->filter($filters)->paginate(20);

        return view('admin.user.users', compact('users', 'request'));
    }

    /**
     * Return user edit page
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->user->with('roles')->find($id);
        $roles = $this->role->all();

        return view('admin.user.edit', compact('user', 'roles'));
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
        $flash = $action->execute($request->validated(), $id);
        $request->session()->flash($flash['type'], $flash['message']);
        
        return redirect()->back();
    }
}
