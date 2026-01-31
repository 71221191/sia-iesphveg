<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'academic_period_id', 'name', 'teacher_id', 'vacancy_limit', 'is_closed', 'acta_number', 'acta_close_date', 'created_at', 'updated_at',
    ];

    protected $casts = [
        'is_closed' => 'boolean',
        'acta_close_date' => 'datetime', // o 'date' si solo guardas la fecha
    ];

    // Relación con Course (una sección pertenece a un curso)
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Relación con AcademicPeriod (una sección pertenece a un período académico)
    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    // Relación con Teacher (el docente es un User)
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id'); // teacher_id referencia a users.id
    }

    // Relación con Enrollments (una sección tiene muchas matrículas)
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrollmentDetails()
    {
        // Una sección tiene muchos alumnos matriculados
        return $this->hasMany(EnrollmentDetail::class, 'course_section_id');
    }
}
