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
        'name', 'surname', 'email', 'phone', 'address', 'country', 'city', 'postcode', 'password', 'status',
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
     * OneToMany relationship with Order class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    /**
     * Update user status
     *
     * @param $ids
     * @param $status
     */
    public function setStatus($ids, $status)
    {
        if (is_array($ids)) {
            foreach ($ids as $id => $value) {
                $user = User::find($id);
                $user->status = $status;
                $user->save();
            }
        } else {
            $user = User::findOrFail($ids);
            $user->status = $status;
            $user->save();
        }
    }

    /**
     * Checks if user has been given any role
     *
     * @return bool
     */
    public function hasRoleSet()
    {
        return ($this->roles()->count()) ? true : false;
    }

    /**
     * Checks if user has a specific role
     *
     * @param $role
     * @return mixed
     */
    public function hasRole($role)
    {
        return $this->roles->pluck('slug')->contains($role);
    }

    /**
     * Check for existing roles
     *
     * @param $array
     * @param $term
     * @return int|string
     * @throws \Exception
     */
    protected function getIdInArray($array, $term)
    {
        foreach ($array as $key => $value) {
            if ($value == $term) {
                return $key;
            }
        }
        throw new \Exception('Can not find the role');
    }

    /**
     * Assign a role to a user
     *
     * @param $title
     * @throws \Exception
     */
    public function assignRole($title)
    {
        $assignedRoles = array();

        $roles = Role::all()->pluck('slug', 'id');

        switch ($title) {
            case 'admin':
                $assignedRoles[] = $this->getIdInArray($roles, 'admin');
                break;
            case 'user':
                $assignedRoles[] = $this->getIdInArray($roles, 'user');
                break;
            default:
                throw new \Exception('The role entered does not exist');
        }

        $this->roles()->sync($assignedRoles);
    }

    /**
     * Return users full name
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->surname;
    }

    /**
     * Return users full adress
     *
     * @return string
     */
    public function getFullAddressAttribute()
    {
        return $this->city . ', ' . $this->address . ', ' . $this->postcode;
    }
}
