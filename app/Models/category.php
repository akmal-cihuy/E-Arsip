<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model {
    protected $fillable = ['name', 'slug', 'description'];

    protected static function boot() {
        parent::boot();
        static::creating(function ($cat) {
            if (empty($cat->slug)) {
                $cat->slug = Str::slug($cat->name);
            }
        });
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }
}