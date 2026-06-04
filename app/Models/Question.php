<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question_text',
        'question_type',
        'points',
        'order',
    ];

    protected $casts = [
        'points' => 'integer',
        'order' => 'integer',
    ];

    // ===== RELATIONSHIPS =====

    /**
     * Get the quiz this question belongs to.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get all options for this question.
     */
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    /**
     * Get all scores for this question.
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    // ===== HELPER METHODS =====

    /**
     * Get correct option(s).
     */
    public function correctOptions()
    {
        return $this->options()->where('is_correct', true)->get();
    }

    /**
     * Check if answer is correct.
     */
    public function isAnswerCorrect($answer)
    {
        $correctOptions = $this->correctOptions()->pluck('id')->toArray();
        return in_array($answer, $correctOptions);
    }
}