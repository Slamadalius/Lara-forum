<?php

namespace App;

use App\Activity;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        if(auth()->guest()) return;

        foreach(static::getActivitiesToRecord() as $event){
            static::$event(function($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'type' => $event . '_' . strtolower(class_basename($this)),
            'user_id' => auth()->id()
        ]);
        // Activity::create([
        //     'type' => $event . '_' . strtolower(class_basename($this)),
        //     'user_id' => auth()->id(),
        //     'subject_id' => $this->id,
        //     'subject_type' => get_class($this)
        // ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}