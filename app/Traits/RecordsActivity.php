<?php

namespace App\Traits;

use App\Models\Activity;

trait RecordsActivity
{
    /**
     * Boot the trait.
     */
    protected static function bootRecordsActivity()
    {
        if (auth()->guest())
            return;

        foreach (static::eventsToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }

    /**
     * Which events to record.
     */
    protected static function eventsToRecord()
    {
        return ['created', 'updated', 'deleted'];
    }

    /**
     * Record activity for the model.
     */
    protected function recordActivity($event)
    {
        // Don't record updates if nothing changed (optional optimization)
        // if ($event === 'updated' && empty($this->getChanges())) return;

        Activity::create([
            'user_id' => auth()->id(),
            'organization_id' => auth()->user()->organization_id ?? null,
            'subject_type' => get_class($this),
            'subject_id' => $this->id,
            'action_type' => $event,
            'description' => $this->getActivityDescription($event),
        ]);
    }

    /**
     * Get the description for the activity.
     */
    protected function getActivityDescription($event)
    {
        // Allow models to override this
        $modelName = strtolower(class_basename($this));

        switch ($event) {
            case 'created':
                return "created {$modelName}";
            case 'updated':
                return "updated {$modelName}";
            case 'deleted':
                return "deleted {$modelName}";
            default:
                return "{$event} {$modelName}";
        }
    }
}
