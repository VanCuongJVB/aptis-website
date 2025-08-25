<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id','label','is_correct','order'
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function question() {
        return $this->belongsTo(Question::class);
    }
}
