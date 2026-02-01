<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThesisDocument extends Model
{
    protected $fillable = [
        'thesis_project_id',
        'name',
        'file_path',
        'type' // project, report, final_draft
    ];

    public function project()
    {
        return $this->belongsTo(ThesisProject::class);
    }
}
