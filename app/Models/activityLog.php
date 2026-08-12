<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model {
    protected $fillable = ['user_id', 'document_id', 'activity', 'description', 'ip_address', 'user_agent'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function document() {
        return $this->belongsTo(Document::class);
    }

    public static function log($activity, $description = null, $documentId = null): void {
        self::create([
            'user_id' => auth()->id() ?? 1,
            'document_id' => $documentId,
            'activity' => $activity,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}