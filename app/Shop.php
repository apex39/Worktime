<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'address', 'phone', 'opening_time', 'closing_time', 'break_time'
    ];
    public function users()
    {
    	return $this->belongsToMany(User::class);
    }
    public function workers()
    {
        $workers = array();
        foreach ($this->users as $user) {
            if ($user->checkRole('worker')){
                $workers[] = $user;
            }
        }
        return $workers;
    }
    public function usersWithRoles()
    {
//        $users = $this->users;
//        $users->load(['roles' => function ($query) {
//            $query->where('role_name', '=', 'manager');
////            $query->where('shop_id', '=', $this->shop_id);
//        }]);
        return $this->belongsToMany(User::class)->with('roles')->get();

    }


}
