<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model {
    protected $fillable = [
        'category_id', 'folder_id', 'user_id', 'name',
        'file_name', 'file_path', 'file_type', 'file_size', 'document_date',
        'description', 'status', 'download_count'
    ];

    protected $casts = [
        'document_date' => 'date',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function folder() {
        return $this->belongsTo(Folder::class);
    }

    public function activityLogs() {
        return $this->hasMany(ActivityLog::class);
    }

    public function getFormattedSizeAttribute(): string {
        $bytes = $this->file_size;
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }
}