<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'skill', 'description', 'is_published', 'duration_minutes',
        'allow_seek', 'listens_allowed'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'allow_seek'   => 'boolean',
    ];

    public function questions() {
        return $this->hasMany(Question::class)->orderBy('part')->orderBy('order');
    }

    /**
     * Number of parts for this quiz depending on skill.
     */
    public function partCount(): int
    {
        return match ($this->skill) {
            'reading'   => 5,
            'listening' => 4,
            default     => 1,
        };
    }
}
