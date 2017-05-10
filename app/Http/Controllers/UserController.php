<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
	protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Return profile view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('user.profile', ['user' => Auth::user()]);
    }

    /**
     * Return users list view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::with('roles')->orderBy('id', 'Asc')->paginate(20);

        return view('admin.user.users', ['users' => $users]);
    }

    /**
     * Return user edit page
     *
     * @param $id
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

    public function update(Request $request, $id)
    {
        // Delete specification
        if ($request['submit'] === 'delete') {
            $user = new User();
            $user->deleteUser($id);

            $request->session()->flash('message-success', 'User deleted!');
            return redirect()->route('user.index');
        }

        // Update specification
        if ($request['submit'] === 'save') {
            $user = User::find($id);

            $user->save();

            $request->session()->flash('message-success', 'User successfully updated!');
            return redirect()->back();
        }

        $request->session()->flash('message-danger', 'Invalid form action!');
        return redirect()->back();
    }

    /**
     * Edit user
     *
     * @param $id
     */
    public function delete($id)
    {
        $user = new User();
        $user->deleteUser($id);
    }

    /**
     * Users mass action
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function massAction(Request $request)
    {
        $userIds = $request->input('users');
        $user = new User();

        switch ($request->input('mass-action')) {
            case 1:
                $user->deleteUser($userIds);
                $request->session()->flash('message-success', 'User(s) deleted!');
                break;
        }

        return redirect()->back();
    }
}
