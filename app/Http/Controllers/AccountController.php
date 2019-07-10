<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Actions\Account\AccountUpdateAction;
use App\Http\Requests\Account\AccountUpdateRequest;

class AccountController extends Controller
{
    /**
     * Return account orders view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $orders = Auth::user()->orders()->active()->paginate(20);

        return view('account.index', compact('orders'));
    }

    /**
     * Return user order view
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showOrder($id)
    {
        $user = Auth::user();
        $order = $user->orders()->findOrFail($id);

        return view('account.order', compact('user', 'order'));
    }

    /**
     * Return account edit view
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $user = Auth::user();
        return view('account.edit', compact('user', 'request'));
    }

    /**
     * Update user information
     *
     * @param \App\Http\Requests\Account\AccountUpdateRequest $request
     * @param AccountUpdateAction $action
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AccountUpdateRequest $request, AccountUpdateAction $action, $id)
    {
        $flash = $action->execute($request->validated(), $id);

        $request->session()->flash($flash['type'], $flash['message']);
        return redirect()->back();
    }

    /**
     * Return account orders history view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showHistory()
    {
        $orders = Auth::user()->orders()->finished()->paginate(20);

        return view('account.history', compact('orders'));
    }
}
