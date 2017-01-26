<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model 
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'action_id', 'finished'
    ];

    public function actionType()
    {
		return $this->hasOne(ActionType::class);
    }

    public function user()
    {
		return $this->belongsTo(User::class);
    }
}
