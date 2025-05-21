<?php

namespace App\Models;

use App\Services\ActivityLogger;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'start_time',
        'end_time',
        'allow_discussion',
        'user_id',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
    ];

    public function hasEnded()
    {
        $endDateTime = Carbon::parse($this->start_date->format('Y-m-d') . ' ' . $this->end_time->format('H:i:s'));
        return now()->greaterThan($endDateTime);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }
    protected static function booted()
    {
        static::saving(function ($program) {
            // Preserve manual status updates
            if ($program->status === 'successful') return;

            $now = now();
            $endDateTime = Carbon::parse(
                $program->start_date->format('Y-m-d') . ' ' . $program->end_time->format('H:i:s')
            );

            $program->status = match(true) {
                $endDateTime->isPast() => 'inactive',
                $program->start_date->isFuture() => 'upcoming',
                default => 'active'
            };
        });
        static::created(function ($program) {
            ActivityLogger::log("Created program: {$program->name}", $program);
        });
    
        static::updated(function ($program) {
            ActivityLogger::log("Updated program: {$program->name}", $program);
        });
    
        static::deleted(function ($program) {
            ActivityLogger::log("Deleted program: {$program->name}", $program);
        });
    }
}
