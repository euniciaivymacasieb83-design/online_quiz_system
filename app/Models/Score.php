<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_id',
        'question_id',
        'student_answer',
        'is_correct',
        'points',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'points' => 'integer',
    ];

    // ===== RELATIONSHIPS =====

    /**
     * Get the attempt this score belongs to.
     */
    public function attempt()
    {
        return $this->belongsTo(Attempt::class);
    }

    /**
     * Get the question this score is for.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the student through the attempt.
     */
    public function student()
    {
        return $this->attempt->student();
    }
}