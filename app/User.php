<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'address', 'country', 'city', 'postcode', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Role');
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
}
