<?php

namespace App\Actions\User;

use App\Models\User;

class UserActionAction
{
    /**
     * Process the user mass-action action
     *
     * @param array $data
     * @return mixed
     */
    public function execute(array $data)
    {
        if (isset($data['users'])) {
            $userIds = $data['users'];
            $user = new User();

            switch ($data['mass-action']) {
                case 1:
                    $user->setStatus($userIds, User::USER_ENABLED);
                    $flash = [
                        'type' => 'message-success',
                        'message' => 'User(s) enabled!'
                    ];
                    return $flash;
                case 2:
                    $user->setStatus($userIds, User::USER_DISABLED);
                    $flash = [
                        'type' => 'message-success',
                        'message' => 'User(s) disabled!'
                    ];
                    return $flash;
            }
        }

        return;
    }
}
