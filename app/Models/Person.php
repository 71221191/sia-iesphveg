<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'people';

    protected $fillable = [
        'user_id', 'identity_document_type_id', 'dni', 'names', 'last_name_p', 'last_name_m',
        'gender', 'birth_date', 'nationality', 'phone', 'address', 'ubigeo_birth_id',
        'ubigeo_residence_id', 'marital_status_id', 'native_language_id', 'ethnicity_id',
        'has_disability', 'disability_type_id', 'conadis_number', 'minedu_code',

        'marital_status_text', 'has_license', 'license_resolution', 'is_rebred_beneficiary',
        'rebred_resolution', 'scholarship_modality', 'scholarship_resolution',
        'has_approved_project', 'project_name', 'has_work', 'work_type',
        'has_previous_studies', 'previous_studies_at', 'study_plan_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrollments()
    {
        // Una persona tiene muchas matrículas
        return $this->hasMany(Enrollment::class);
    }

    public function studyPlan()
    {
        return $this->belongsTo(StudyPlan::class);
    }

    public function socioeconomicFiles()
    {
        return $this->hasMany(SocioeconomicFile::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->last_name_p} {$this->last_name_m}, {$this->names}";
    }
}
