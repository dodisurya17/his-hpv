<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    protected $fillable = ['name', 'question', 'answer', 'answered_by', 'answered_at'];

    protected $casts = [
        'answered_at' => 'datetime',
    ];

    public function answeredBy()
    {
        return $this->belongsTo(User::class, 'answered_by');
    }

    public function scopeAnswered(Builder $query): Builder
    {
        return $query->whereNotNull('answer');
    }

    public function scopeUnanswered(Builder $query): Builder
    {
        return $query->whereNull('answer');
    }
}
