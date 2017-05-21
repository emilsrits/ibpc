<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

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

        return view('admin.user.users', ['users' => $users]);
    }

    /**
     * Users mass action
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function action(Request $request)
    {
        $userIds = $request->input('users');
        $user = new User();

        switch ($request->input('mass-action')) {
            case 1:
                $user->setStatus($userIds, 1);
                $request->session()->flash('message-success', 'User(s) enabled!');
                break;
            case 2:
                $user->setStatus($userIds, 0);
                $request->session()->flash('message-success', 'User(s) disabled!');
                break;
        }

        return redirect()->back();
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
        if ($request['submit'] === 'save') {
            $user = User::find($id);

            if (!$this->userValidate($user, $request)) {
                return redirect()->back();
            }

            $user->name = $request['name'];
            $user->surname = $request['surname'];
            $user->email = $request['email'];
            $user->country = $request['country'];
            $user->city = $request['city'];
            $user->address = $request['address'];
            $user->postcode = $request['postcode'];

            if (!Hash::check($request['password'], $user->password)) {
                if (!ctype_space($request['password']) && !$request['password'] == "") {
                    $user->password = bcrypt($request['password']);
                }
            }

            if ($request['role']) {
                // Attach new roles
                $roles = collect($request['role'])->sortBy('id');
                foreach ($roles as $role => $id) {
                    foreach ($id as $key => $value) {
                        $role = $user->roles->find($value);
                        if (!$role) {
                            $user->roles()->attach(['role_id' => ['role_id' => $value]]);
                            continue;
                        }
                    }
                }
                // Remove unchecked roles
                if ($user->roles->first()) {
                    foreach ($user->roles as $role) {
                        $roleId = $role->id;
                        $matchFound = false;
                        foreach ($roles as $role => $id) {
                            foreach ($id as $key => $value) {
                                if ((int)$value === $roleId) {
                                    $matchFound = true;
                                    continue;
                                }
                            }
                        }
                        if (!$matchFound) {
                            $user->roles()->detach(['role_id' => ['role_id' => $roleId]]);
                        }
                    }
                }
            } else {
                $request->session()->flash('message-danger', 'User must have a role!');
                return redirect()->back();
            }

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
     * Validate user edit form
     *
     * @param $user
     * @param $request
     * @return bool
     */
    protected function userValidate($user, $request)
    {
        if (ctype_space($request['name']) || $request['name'] == "") {
            $request->session()->flash('message-danger', 'Missing name!');
            return false;
        }
        if (ctype_space($request['surname']) || $request['surname'] == "") {
            $request->session()->flash('message-danger', 'Missing surname!');
            return false;
        }
        $this->validate($request, [
            'name' => 'max:20',
            'surname' => 'max:20',
            'password' => 'min:6'
        ]);
        if ($user->email != $request['email']) {
            $this->validate($request, [
                'email'  => 'email|max:255|unique:users,email'
            ]);
        }

        return true;
    }

    /**
     * Check if user exists by email
     *
     * @param $email
     * @return mixed
     */
    protected function userExists($email) {
        return $user = User::where('email', $email)->exists();
    }
}
