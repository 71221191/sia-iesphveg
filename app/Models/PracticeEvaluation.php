<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticeEvaluation extends Model
{
    protected $fillable = ['practice_assignment_id', 'institute_score', 'school_score', 'final_score', 'observations'];

    public function assignment() {
        return $this->belongsTo(PracticeAssignment::class);
    }
}
