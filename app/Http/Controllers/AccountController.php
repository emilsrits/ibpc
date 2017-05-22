<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class AccountController extends Controller
{
    /**
     * Return account orders view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        $orderStatuses = [
          'pending', 'invoiced', 'shipped'
        ];

        $orders = $user->orders()->whereIn('status', $orderStatuses)->get();

        return view('account.index', ['user' => $user, 'orders' => $orders]);
    }

    /**
     * Return user order view
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showOrder($id)
    {
        $user = Auth::user();

        $order = $user->orders()->find($id);

        return view('account.order', ['user' => $user, 'order' => $order]);
    }

    /**
     * Return account edit view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        return view('account.edit', ['user' => Auth::user()]);
    }

    /**
     * Update user information
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
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
            $user->phone = $request['phone'];
            if ($request['country']) {
                $user->country = $request['country'];
            }
            $user->city = $request['city'];
            $user->address = $request['address'];
            $user->postcode = $request['postcode'];

            if (!Hash::check($request['password'], $user->password)) {
                if (!ctype_space($request['password']) && !$request['password'] == "") {
                    $user->password = bcrypt($request['password']);
                }
            }

            $user->save();

            $request->session()->flash('message-success', 'Account successfully updated!');
            return redirect()->back();
        }

        $request->session()->flash('message-danger', 'Invalid form action!');
        return redirect()->back();
    }

    /**
     * Return account orders history view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showHistory()
    {
        $user = Auth::user();

        $orderStatuses = [
            'canceled', 'completed'
        ];

        $orders = $user->orders()->whereIn('status', $orderStatuses)->get();

        return view('account.history', ['user' => $user, 'orders' => $orders]);
    }

    /**
     * Validate user update form inputs
     *
     * @param $user
     * @param $request
     * @return bool
     */
    protected function userValidate($user, $request)
    {
        $this->validate($request, [
            'name' => 'max:20',
            'surname' => 'max:20',
            'phone' => 'regex:/^\(?\+?\(?\d{0,3}\)?\s?\d{8}$/',
            'password' => 'min:6|confirmed',
            'current_password' => 'required'
        ]);
        if ($user->email != $request['email']) {
            $this->validate($request, [
                'email'  => 'email|max:25|unique:users,email'
            ]);
        }
        if (ctype_space($request['name']) || $request['name'] == "") {
            $request->session()->flash('message-danger', 'Missing name!');
            return false;
        }
        if (ctype_space($request['surname']) || $request['surname'] == "") {
            $request->session()->flash('message-danger', 'Missing surname!');
            return false;
        }
        if (!Hash::check($request['current_password'], $user->password)) {
            $request->session()->flash('message-danger', 'Incorrect current password!');
            return false;
        }

        return true;
    }
}
