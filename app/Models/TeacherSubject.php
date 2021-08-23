<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherSubject extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function teacher()
    {
        return $this->belongsTo(\scheduler\Models\Teacher::class, 'teacher_id')->withTrashed();
    }

    public function subject()
    {
        return $this->belongsTo(\scheduler\Models\Subject::class, 'subject_id')->withTrashed();
    }

    public function room()
    {
        return $this->belongsTo(\scheduler\Models\Room::class, 'room_id')->withTrashed();
    }
}
