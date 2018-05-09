<?php

namespace App;

use App\Activity;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        //if it is not authenticated user don't do anything.
        if(auth()->guest()) return;

        //loop through getActivities array
        foreach(static::getActivitiesToRecord() as $event){
            static::$event(function($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }

    //static function returning array of type of activity
    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        //because of morph relationship you don't need to specify subject_id subject_type
        $this->activity()->create([
            //type => created_thread
            'type' => $event . '_' . strtolower(class_basename($this)),
            'user_id' => auth()->id()
        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}