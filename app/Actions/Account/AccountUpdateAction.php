<?php

namespace App\Actions\Account;

use App\User;

class AccountUpdateAction
{
    /**
     * Process the account update action
     *
     * @param array $data
     * @param string $id
     * @return array
     */
    public function execute(array $data, $id)
    {
        $user = User::findOrFail($id);

        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        if ($data['password'] !== null && $data['password'] !== "") {
            $user->password = bcrypt($data['password']);
        }
        $user->country = $data['country'];
        $user->city = $data['city'];
        $user->address = $data['address'];
        $user->postcode = $data['postcode'];
        $user->save();

        $flash = [
            'type' => 'message-success',
            'message' => 'Account successfully updated!'
        ];

        return $flash;
    }
}