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
        $shop_opening = Carbon::createFromFormat("H:i:s",$this->shops->first()->opening_time);
        $start_work_differences_sum = 0;
        foreach ($this->records()->where('action_id',1)->get() as $record) {
            $helper_date = $record->created_at->setDate(Carbon::now()->year, Carbon::now()->month, Carbon::now()->day);
            $start_work_differences_sum += $helper_date->diffInMinutes($shop_opening, false);
        }
        $average_minutes = $start_work_differences_sum/$this->records()->where('action_id',1)->get()->count();
        $average_time = clone $shop_opening;
        $average_time->subMinutes($average_minutes);
        $human_output = $average_time->diffForHumans($shop_opening);

        return $human_output;
    }

    public function workCoverage(){
        $work_records = $this->records()->where(['action_id'=>1, 'finished' => true])->get();
        $break_records = $this->records()->where(['action_id'=>2, 'finished' => true])->get();
        $work_time = 0;
        foreach($work_records as $record) {
            $work_time += $record->created_at->diffInMinutes($record->updated_at);
        }
        Log::info("work_time: ".$work_time);
        $available_break_time = $work_records->count() * $this->shops->first()->break_time; //Break time sum for every worked day
        Log::info("available_break_time: ".$available_break_time);
        $break_time = 0;
        foreach($break_records as $record) {
            $break_time += $record->created_at->diffInMinutes($record->updated_at);
        }
        Log::info("break_time: ".$break_time);
        if($break_time>$available_break_time) {
            Log::info("break_time reduction hit");
            $work_time = $work_time-($break_time-$available_break_time);
        }
        $avg_work_time = $work_time/$work_records->count();
        Log::info("avg_work_time: ".$avg_work_time);
        $user_working_hours = $this->working_hours;
        Log::info("user_working_hours: ".$user_working_hours);
        return round($avg_work_time/$user_working_hours,1);
    }
}