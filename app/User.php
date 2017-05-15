<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'phone', 'address', 'country', 'city', 'postcode', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * ManyToMany relationship with Role class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    /**
     * Delete user
     *
     * @param $ids
     */
    public function deleteUser($ids)
    {
        if (is_array($ids)) {
            foreach ($ids as $id => $value) {
                $user = User::find($id);
                $user->destroy($id);
            }
        } else {
            $user = User::findOrFail($ids);
            $user->destroy($ids);
        }

    }

    // Checks if user has been given any role
    public function hasRoleSet()
    {
        return ($this->roles()->count()) ? true : false;
    }

    // Checks if user has a specific role
    public function hasRole($role)
    {
        return $this->roles->pluck('slug')->contains($role);
    }

    private function getIdInArray($array, $term)
    {
        foreach ($array as $key => $value) {
            if ($value == $term) { // 1 => "admin", 2 => "moderator" ...
                return $key;
            }
        }
        throw new \Exception('Cant get the ID in array');
    }

    public function assignRole($title)
    {
        $assignedRoles = array();

        $roles = Role::all()->pluck('slug', 'id');

        switch ($title) {
            case 'admin':
                $assignedRoles[] = $this->getIdInArray($roles, 'admin');
                break;
            case 'mod':
                $assignedRoles[] = $this->getIdInArray($roles, 'mod');
                break;
            case 'sup':
                $assignedRoles[] = $this->getIdInArray($roles, 'sup');
                break;
            case 'user':
                $assignedRoles[] = $this->getIdInArray($roles, 'user');
                break;
            default:
                throw new \Exception('The role status entered does not exist');
        }

        $this->roles()->sync($assignedRoles);
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->surname;
    }
}
