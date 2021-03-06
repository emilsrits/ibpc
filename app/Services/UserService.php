<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserService
{
    /**
     * Create a new service instance.
     * 
     * @param User $user
     * @param UserRepository $userRepository
     */
    public function __construct(User $user, UserRepository $userRepository)
    {
        $this->user = $user;
        $this->userRepository = $userRepository;
    }

    /**
     * User mass action
     *
     * @param array $data
     * @return mixed
     */
    public function action(array $data)
    {
        if (isset($data['user'])) {
            $userIds = $data['user'];

            switch ($data['mass-action']) {
                case 1:
                    $this->user->setStatus($userIds, User::USER_STATUS_ENABLED);
                    flashMessage('message-success', 'User(s) enabled!');
                    return true;
                case 2:
                    $this->user->setStatus($userIds, User::USER_STATUS_DISABLED);
                    flashMessage('message-success', 'User(s) disabled!');
                    return true;
            }
            return false;
        }
    }

    /**
     * User update action
     *
     * @param array $data
     * @param User $user
     */
    public function update(array $data, User $user)
    {
        if ($data['password'] !== null && $data['password'] !== "") {
            $user->password = bcrypt($data['password']);
        }
        unset($data['password']);

        if (isset($data['role'])) {
            $user->updateRoles($data['role']);
        }
        unset($data['role']);

        $this->userRepository->update($data, $user);

        flashMessage('message-success', 'Account successfully updated!');
    }
}
