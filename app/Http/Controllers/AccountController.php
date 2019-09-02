<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Account\AccountUpdateRequest;

class AccountController extends Controller
{
    /**
     * AccountController constructor
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Return account orders view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $orders = $user->getActiveOrders(20);

        return view('pages.account.index', compact('orders'));
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
        $order = $user->getOrder($id);

        return view('pages.account.order', compact('user', 'order'));
    }

    /**
     * Return account orders history view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showHistory()
    {
        $user = Auth::user();
        $orders = $user->getFinishedOrders(20);

        return view('pages.account.history', compact('orders'));
    }

    /**
     * Return account edit view
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $user = Auth::user();
        return view('pages.account.edit', compact('user'));
    }

    /**
     * Update user information
     *
     * @param \App\Http\Requests\Account\AccountUpdateRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AccountUpdateRequest $request, User $user)
    {
        $this->userService->update($request->validated(), $user);

        return redirect()->back();
    }
}
