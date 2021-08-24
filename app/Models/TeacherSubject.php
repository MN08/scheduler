<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\App;

class TeacherSubject extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function teachersubject()
    {
        return $this->belongsTo(App\Models\Teacher::class, 'teacher_id')->withTrashed();
    }

    public function subject()
    {
        return $this->belongsTo(App\Models\Subject::class, 'subject_id')->withTrashed();
    }

    public function room()
    {
        return $this->belongsTo(App\Models\Room::class, 'room_id')->withTrashed();
    }
}
