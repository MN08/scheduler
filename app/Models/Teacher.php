<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\App;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function teachersubject()
    {
        return $this->hasMany(TeacherSubject::class);
    }
}
