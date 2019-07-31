<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * @var array
     */
    public $message;

    /**
     * @var User
     */
    protected $user;

    /**
     * Create a new service instance.
     * 
     * @param array $message
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->message = [
            'type' => null,
            'content' => null
        ];
        $this->user = $user;
    }

    /**
     * User mass action
     *
     * @param array $data
     * @return mixed
     */
    public function action(array $data)
    {
        if (isset($data['users'])) {
            $userIds = $data['users'];

            switch ($data['mass-action']) {
                case 1:
                    $this->user->setStatus($userIds, User::USER_ENABLED);
                    $this->message = [
                        'type' => 'message-success',
                        'content' => 'User(s) enabled!'
                    ];
                    return true;
                case 2:
                    $this->user->setStatus($userIds, User::USER_DISABLED);
                    $this->message = [
                        'type' => 'message-success',
                        'content' => 'User(s) disabled!'
                    ];
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

        $user->update($data);

        $this->message = [
            'type' => 'message-success',
            'content' => 'Account successfully updated!'
        ];
    }
}