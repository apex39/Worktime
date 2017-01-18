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
        'name', 'username', 'email', 'password','surname', 'role', 'shop_id', 'active', 'worker_id'
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
        return $this->belongsToMany(Role::class);
    }

    public function shops()
    {
        return $this->belongsToMany(Shop::class);
    }
    
    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function checkRole($roleName)
    {
        foreach ($this->roles()->get() as $role)
        {
            if ($role->role_name == $roleName)
            {
                return true;
            }
        }

        return false;
    }
}