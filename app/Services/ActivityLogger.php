<?php

// app/Services/ActivityLogger.php
namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class ActivityLogger
{
     public static function log(string $description, $subject = null)
    {
        if (!auth()->check()) {
            // No authenticated user, skip logging
            return null;
        }
        return ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => $description,
            'subject_id' => $subject ? $subject->id : null,
            'subject_type' => $subject ? get_class($subject) : null
        ]);
    }

    public static function logWithProperties(string $description, ?Model $subject = null, array $properties = []): ?ActivityLog
    {
        if (!auth()->check()) {
            // No authenticated user, skip logging
            return null;
        }
        return ActivityLog::create([
            'user_id'       => auth()->id(),
            'description'   => $description,
            'subject_id'    => $subject ? $subject->id : null,
            'subject_type'  => $subject ? get_class($subject) : null,
            'properties'    => $properties
        ]);
    }
}