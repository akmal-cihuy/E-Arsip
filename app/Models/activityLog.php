<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model {
    protected $fillable = ['user_id', 'file_id', 'activity', 'description', 'user_agent'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function file() {
        return $this->belongsTo(File::class);
    }

    public static function log($activity, $description = null, $fileId = null): void {
        self::create([
            'user_id' => auth()->id() ?? 1,
            'file_id' => $fileId,
            'activity' => $activity,
            'description' => $description,
            'user_agent' => request()->userAgent(),
        ]);
    }
}