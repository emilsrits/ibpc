<?php

namespace App\Http\Controllers;

use App\Admin\Tables\UserTable;
use App\Models\User;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\User\UserActionRequest;
use App\Filters\UserFilter;
use App\Services\UserService;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;

class UserController extends Controller
{
    /**
     * UserController constructor
     *
     * @param UserService $userService
     * @param UserRepository $userRepository
     * @param UserTable $userTable
     * @param RoleRepository $roleRepository
     */
    public function __construct(
        UserService $userService,
        UserRepository $userRepository,
        UserTable $userTable,
        RoleRepository $roleRepository
    ) {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->userTable = $userTable;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Return users list view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.user.users', [
            'users' => $this->userRepository->paginate(),
            'table' => $this->userTable
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
        $this->userService->action($request->validated());

        $users = $this->userRepository->filter($filters)->paginate();
        $table = $this->userTable;

        return view('admin.user.users', compact('users', 'table', 'request'));
    }

    /**
     * Return user edit page
     *
     * @param User @user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = $this->roleRepository->all();

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

        return redirect()->back();
    }
}
