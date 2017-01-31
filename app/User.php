<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Log;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password','surname', 'role', 'shop_id', 'active', 'worker_id', 'working_hours'
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

    public function punctuality(){
        Log::info("=========================");
        $shop_opening = Carbon::createFromFormat("H:i:s",$this->shops->first()->opening_time);
        $start_work_differences_sum = 0;
        foreach ($this->records()->where('action_id',1)->get() as $record) {
            $helper_date = $record->created_at->setDate(Carbon::now()->year, Carbon::now()->month, Carbon::now()->day);
            $start_work_differences_sum += $helper_date->diffInMinutes($shop_opening, false);
            Log::info("Record date: ".$record->created_at);
            Log::info("Helper date: ".$helper_date);
            Log::info("Shop opening: ".$shop_opening);
            Log::info("diffInMinutes: ". $start_work_differences_sum);
        }
        $average_minutes = $start_work_differences_sum/$this->records()->where('action_id',1)->get()->count();
        $average_time = clone $shop_opening;
        $average_time->subMinutes($average_minutes);
        $human_output = $average_time->diffForHumans($shop_opening);
        Log::info("average_minutes: ".$average_minutes);
        Log::info("average_time: ".$average_time);
        Log::info("Shop opening: ".$shop_opening);
        Log::info("human_outpu: ". $human_output);
        return $human_output;
    }

    public function workCoverage(){
    }
}