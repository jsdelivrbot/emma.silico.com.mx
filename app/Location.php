<?php

namespace EMMA5;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['name', 'capacity'];//TODO Add annotations

    public function users()
    {
        /**
         * return $this->belongsToMany('\App\Task','menu_task_user')
        ->withPivot('menu_id','status');
         */
        return $this->belongsToMany('EMMA5\User', 'exam_user')->withPivot('location_id');
    }

    //Floor plan for the location
    public function floorPlan()
    {
        return $this->morphMany('EMMA5\Image', 'imageable');
    }
}
