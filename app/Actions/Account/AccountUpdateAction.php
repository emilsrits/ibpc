<?php

namespace App\Actions\Account;

use App\Models\User;

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

        if ($data['password'] !== null && $data['password'] !== "") {
            $user->password = bcrypt($data['password']);
        }
        unset($data['password']);

        $user->update($data);

        $flash = [
            'type' => 'message-success',
            'message' => 'Account successfully updated!'
        ];

        return $flash;
    }
}