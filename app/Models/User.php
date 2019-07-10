<?php

namespace App\Models;

use Carbon\Carbon;
use App\Filters\QueryFilter;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const USER_ENABLED = 1;
    const USER_DISABLED = 0;

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'address', 'country', 'city', 'postcode', 'password', 'status'
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
        return $this->belongsToMany('App\Models\Role');
    }

    /**
     * OneToMany relationship with Order class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    /**
     * User filters
     *
     * @param $query
     * @param UserFilter $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Update user status
     *
     * @param array|string $ids
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
     * Create invoice file and send email to user about the order
     *
     * @param \Illuminate\Support\Facades\Auth $user
     * @param \App\Models\Order $order
     */
    public function invoice($user, $order)
    {
        // Generate PDF invoice file
        $pdf = PDF::loadView('pdf.invoice', ['user' => $user, 'order' => $order]);

        // Send mail with order info and attached invoice
        Mail::send('emails.invoice', ['user' => $user, 'order' => $order], function($message) use($pdf, $user, $order)
        {
            $message->to($user->email)->subject('Invoice for order #' . $order->id);
            $message->attachData($pdf->output(), $order->id .'-invoice.pdf');
        });

        // Save copy of invoice locally
        if (config('constants.invoice_storage')) {
            $now = Carbon::now();
            Storage::put('orders/' . $now->year . '/' . $now->month . '/' . $order->id .'-invoice-' . str_random(2) . '.pdf', $pdf->output());
        }
    }

    /**
     * Check if user is allowed to make an order
     * 
     * @return bool
     */
    public function canMakeOrder()
    {
        if (!$this->country || !$this->city || !$this->address || !$this->postcode) {
            return false;
        } else {
            return true;
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
     * @param Collection $roles
     * @param string $slug
     * @return string
     */
    protected function getIdInArray($roles, $slug)
    {
        foreach ($roles as $key => $value) {
            if ($value == $slug) {
                return $key;
            }
        }
    }

    /**
     * Assign a role to a user
     *
     * @param string $slug
     * @throws \Exception
     */
    public function assignRole($slug)
    {
        $assignedRoles = array();

        $roles = Role::all()->pluck('slug', 'id');

        switch ($slug) {
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
     * Update user roles
     *
     * @param array $roles
     */
    public function updateRoles($roles)
    {
        $this->roles()->sync(array_column($roles, 'id'));
    }

    /**
     * Return users full name
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Return users full adress
     *
     * @return string
     */
    public function getFullAddressAttribute()
    {
        $arr = [];
        if ($this->country) {
            array_push($arr, countryFromCode($this->country));
        }
        if ($this->city) {
            array_push($arr, $this->city);
        }
        if ($this->address) {
            array_push($arr, $this->address);
        }
        if ($this->postcode) {
            array_push($arr, $this->postcode);
        }
        $fullAdress = implode(', ', $arr);

        return $fullAdress;
    }
    
    /**
     * Set users country attribute depending on its value
     * 
     * @param string $country
     */
    public function setCountryAttribute($country)
    {
        if ($country == '0') {
            $this->attributes['country'] = null;
        } else {
            $this->attributes['country'] = $country;
        }
    }
}
