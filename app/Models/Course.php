<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'course_introduction',
    ];
    public function teacher() {
        return $this->hasMany(Teacher::class, 'course_id', 'id');
    }
    public function curriculum() {
        return $this->hasMany(Curriculum::class, 'course_id', 'id');
    }

}
