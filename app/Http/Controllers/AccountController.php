<?php

namespace App\Http\Controllers;

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
        $user = Auth::user();
        $orderStatuses = config('constants.order_status_active');
        $orders = $user->orders()->whereIn('status', $orderStatuses)->get();

        return view('account.index', ['user' => $user, 'orders' => $orders]);
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
     * @param \App\Http\Requests\Account\AccountUpdateRequest $request
     * @param \App\Actions\User\AccountUpdateAction $action
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AccountUpdateRequest $request, AccountUpdateAction $action, $id)
    {
        $flash = $action->execute($request->all(), $id);

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
        $user = Auth::user();
        $orderStatuses = config('constants.order_status_finished');
        $orders = $user->orders()->whereIn('status', $orderStatuses)->get();

        return view('account.history', ['user' => $user, 'orders' => $orders]);
    }
}
