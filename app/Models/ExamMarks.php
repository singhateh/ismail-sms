<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamMarks extends Model
{
    use HasFactory;
    protected $fillable = ['student_mark_id', 'assign_subject_id', 'dt_marks','tt_marks', 'ef_marks'];
}
