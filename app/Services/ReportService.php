<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Person;

class ReportService
{
    public function getConsolidatedHistory($personId)
    {
        // Esta consulta es "Nivel Senior".
        // 1. Busca el último ID de detalle aprobado para cada curso único.
        // 2. Trae toda la información de ese registro específico.

        $subquery = DB::table('enrollment_details as ed')
            ->join('enrollments as e', 'ed.enrollment_id', '=', 'e.id')
            ->select('ed.course_id', DB::raw('MAX(ed.id) as last_detail_id'))
            ->where('e.person_id', $personId)
            ->where('ed.status', 'approved')
            ->groupBy('ed.course_id');

        return DB::table('enrollment_details as detail')
            ->joinSub($subquery, 'latest', function ($join) {
                $join->on('detail.id', '=', 'latest.last_detail_id');
            })
            ->join('courses as c', 'detail.course_id', '=', 'c.id')
            ->join('enrollments as e', 'detail.enrollment_id', '=', 'e.id')
            ->join('academic_periods as ap', 'e.academic_period_id', '=', 'ap.id')
            ->select(
                'c.name as course_name',
                'c.code as course_code',
                'c.cycle',
                'c.credits',
                'detail.final_score_numeric as grade',
                'ap.name as period_name'
            )
            ->orderBy('c.cycle', 'asc')
            ->orderBy('c.name', 'asc')
            ->get();
    }
}
