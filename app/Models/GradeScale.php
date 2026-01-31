<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeScale extends Model
{
    use HasFactory;

    protected $fillable = [
        'study_plan_id',
        'name',
        'min_value',
        'max_value',
        'description',
        'numeric_equivalent'
    ];

    public function studyPlan()
    {
        return $this->belongsTo(StudyPlan::class);
    }
}
