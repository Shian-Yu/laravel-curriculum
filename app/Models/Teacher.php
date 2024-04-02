<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_name',
        'teacher_introduction',
        'course_id',
    ];

    public function course() {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function curriculum() {
        return $this->hasMany(Curriculum::class, 'teacher_id', 'id');
    }

}
