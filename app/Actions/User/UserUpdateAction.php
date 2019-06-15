<?php

namespace App\Actions\User;

use App\User;

class UserUpdateAction
{
    /**
     * Process the user update action
     *
     * @param array $data
     * @param string $id
     * @return array
     */
    public function execute(array $data, $id)
    {
        $user = User::find($id);

        $user->name = $data['name'];
        $user->surname = $data['surname'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->password = $data['password'];
        $user->country = $data['country'];
        $user->city = $data['city'];
        $user->address = $data['address'];
        $user->postcode = $data['postcode'];

        if (isset($data['role'])) {
            // Attach new roles
            $roles = collect($data['role'])->sortBy('id');
            foreach ($roles as $role => $id) {
                foreach ($id as $key => $value) {
                    $role = $user->roles->find($value);
                    if (!$role) {
                        $user->roles()->attach(['role_id' => ['role_id' => $value]]);
                        continue;
                    }
                }
            }
            // Remove unchecked roles
            if ($user->roles->first()) {
                foreach ($user->roles as $role) {
                    $roleId = $role->id;
                    $matchFound = false;
                    foreach ($roles as $role => $id) {
                        foreach ($id as $key => $value) {
                            if ((int)$value === $roleId) {
                                $matchFound = true;
                                continue;
                            }
                        }
                    }
                    if (!$matchFound) {
                        $user->roles()->detach(['role_id' => ['role_id' => $roleId]]);
                    }
                }
            }
        }

        $user->save();

        $flash = [
            'type' => 'message-success',
            'message' => 'Account successfully updated!'
        ];

        return $flash;
    }
}
