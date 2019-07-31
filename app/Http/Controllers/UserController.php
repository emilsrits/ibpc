<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\User\UserActionRequest;
use App\Filters\UserFilter;
use App\Services\UserService;

class UserController extends Controller
{
    /**
     * UserController constructor
     *
     * @param UserService $userService
     * @param User $user
     * @param Role $role
     */
    public function __construct(UserService $userService, User $user, Role $role)
    {
        $this->userService = $userService;
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
            'users' => $this->user->oldest('id')->paginate(20), 
            'request' => null
        ]);
    }

    /**
     * Users mass action
     *
     * @param \App\Http\Requests\User\UserActionRequest $request
     * @param UserFilter $filters
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function action(UserActionRequest $request, UserFilter $filters)
    {
        $action = $this->userService->action($request->validated());

        if ($action) {
            $request->session()->flash($this->userService->message['type'], $this->userService->message['content']);
        }

        $users = $this->user->filter($filters)->paginate(20);

        return view('admin.user.users', compact('users', 'request'));
    }

    /**
     * Return user edit page
     *
     * @param User @user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = $this->role->all();

        return view('admin.user.edit', compact('user', 'roles'));
    }

    /**
     * Update user
     *
     * @param \App\Http\Requests\User\UserUpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->userService->update($request->validated(), $user);

        $request->session()->flash($this->userService->message['type'], $this->userService->message['content']);
        return redirect()->back();
    }
}
