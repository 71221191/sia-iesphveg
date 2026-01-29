<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\DB;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user() ? array_merge(
    $request->user()->only(['id', 'username', 'email']),
    ['roles' => $request->user()->getRoleNames()->toArray()]
    ) : null,
                // Juntamos toda la info para el Dashboard (RF-01.2)
                'student_info' => $request->user() ? DB::table('people')
                    ->join('enrollments', 'people.id', '=', 'enrollments.person_id')
                    ->join('study_plans', 'enrollments.study_plan_id', '=', 'study_plans.id')
                    ->join('study_programs', 'study_plans.study_program_id', '=', 'study_programs.id')
                    ->where('people.user_id', $request->user()->id)
                    ->select(
                        'people.*',
                        'study_programs.name as program_name',
                        'enrollments.cycle',
                        'enrollments.section_label',
                        'enrollments.approval_resolution'
                    )
                    ->first() : null,
            ],
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
                'warning' => $request->session()->get('warning'), // Por si usas este
                'info' => $request->session()->get('info'),     // Por si usas este
            ],
            // ---------------------------------------------
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ];
    }
}
