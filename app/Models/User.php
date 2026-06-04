<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'teacher' or 'student'
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ===== RELATIONSHIPS =====

    /**
     * Get all quizzes created by this teacher.
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'teacher_id');
    }

    /**
     * Get all quiz attempts by this student.
     */
    public function attempts()
    {
        return $this->hasMany(Attempt::class, 'student_id');
    }

    /**
     * Get all scores for this student.
     */
    public function scores()
    {
        return $this->hasMany(Score::class, 'student_id');
    }

    // ===== HELPER METHODS =====

    /**
     * Check if user is a teacher.
     */
    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    /**
     * Check if user is a student.
     */
    public function isStudent()
    {
        return $this->role === 'student';
    }
}

    