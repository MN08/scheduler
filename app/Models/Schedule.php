<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'teacher_subject_id',
        'time_id',
        'school_year_id',
        'day_id',
        'room_id',
    ];

    public function teachersubject()
    {
        return $this->belongsTo(TeacherSubject::class, 'teacher_subject_id');
    }

    public function time()
    {
        return $this->belongsTo(Time::class, 'time_id');
    }


    public function schoolyear()
    {
        return $this->belongsTo(SchoolYear::class, 'school_year_id');
    }

    public function day()
    {
        return $this->belongsTo(Days::class, 'day_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
