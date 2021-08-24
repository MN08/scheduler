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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id',
        'subject_id',
        'grade'
    ];

    public function teacher()
    {
        return $this->belongsTo(App\Models\Teacher::class, 'teacher_id')->withTrashed();
    }

    public function subject()
    {
        return $this->belongsTo(App\Models\Subject::class, 'subject_id')->withTrashed();
    }
}
