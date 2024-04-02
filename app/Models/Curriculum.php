<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    protected $fillable = [
        'teacher_id',
        'course_id',
        'term_id',
    ];
    public function course() {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function term() {
        return $this->belongsTo(Term::class, 'term_id', 'id');
    }
    public function teacher() {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
    }
}
