<?php

namespace App\Actions\User;

use App\Models\User;

class UserUpdateAction
{
    /**
     * Process the user update action
     *
     * @param array $data
     * @param User $user
     * @return array
     */
    public function execute(array $data, $user)
    {
        if ($data['password'] !== null && $data['password'] !== "") {
            $user->password = bcrypt($data['password']);
        }
        unset($data['password']);

        if (isset($data['role'])) {
            $user->updateRoles($data['role']);
        }
        unset($data['role']);

        $user->update($data);

        $flash = [
            'type' => 'message-success',
            'message' => 'User successfully updated!'
        ];

        return $flash;
    }
}
