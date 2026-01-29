import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\ImportController::students
 * @see app/Http/Controllers/Admin/ImportController.php:46
 * @route '/importar-alumnos'
 */
export const students = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: students.url(options),
    method: 'post',
})

students.definition = {
    methods: ["post"],
    url: '/importar-alumnos',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\ImportController::students
 * @see app/Http/Controllers/Admin/ImportController.php:46
 * @route '/importar-alumnos'
 */
students.url = (options?: RouteQueryOptions) => {
    return students.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\ImportController::students
 * @see app/Http/Controllers/Admin/ImportController.php:46
 * @route '/importar-alumnos'
 */
students.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: students.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\ImportController::students
 * @see app/Http/Controllers/Admin/ImportController.php:46
 * @route '/importar-alumnos'
 */
    const studentsForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: students.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\ImportController::students
 * @see app/Http/Controllers/Admin/ImportController.php:46
 * @route '/importar-alumnos'
 */
        studentsForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: students.url(options),
            method: 'post',
        })
    
    students.form = studentsForm
/**
* @see \App\Http\Controllers\Admin\ImportController::courses
 * @see app/Http/Controllers/Admin/ImportController.php:17
 * @route '/importar-cursos-proceso'
 */
export const courses = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: courses.url(options),
    method: 'post',
})

courses.definition = {
    methods: ["post"],
    url: '/importar-cursos-proceso',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\ImportController::courses
 * @see app/Http/Controllers/Admin/ImportController.php:17
 * @route '/importar-cursos-proceso'
 */
courses.url = (options?: RouteQueryOptions) => {
    return courses.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\ImportController::courses
 * @see app/Http/Controllers/Admin/ImportController.php:17
 * @route '/importar-cursos-proceso'
 */
courses.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: courses.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\ImportController::courses
 * @see app/Http/Controllers/Admin/ImportController.php:17
 * @route '/importar-cursos-proceso'
 */
    const coursesForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: courses.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\ImportController::courses
 * @see app/Http/Controllers/Admin/ImportController.php:17
 * @route '/importar-cursos-proceso'
 */
        coursesForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: courses.url(options),
            method: 'post',
        })
    
    courses.form = coursesForm
/**
* @see \App\Http\Controllers\Admin\ImportController::active_students
 * @see app/Http/Controllers/Admin/ImportController.php:72
 * @route '/importar-alumnos-activos'
 */
export const active_students = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: active_students.url(options),
    method: 'post',
})

active_students.definition = {
    methods: ["post"],
    url: '/importar-alumnos-activos',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\ImportController::active_students
 * @see app/Http/Controllers/Admin/ImportController.php:72
 * @route '/importar-alumnos-activos'
 */
active_students.url = (options?: RouteQueryOptions) => {
    return active_students.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\ImportController::active_students
 * @see app/Http/Controllers/Admin/ImportController.php:72
 * @route '/importar-alumnos-activos'
 */
active_students.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: active_students.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\ImportController::active_students
 * @see app/Http/Controllers/Admin/ImportController.php:72
 * @route '/importar-alumnos-activos'
 */
    const active_studentsForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: active_students.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\ImportController::active_students
 * @see app/Http/Controllers/Admin/ImportController.php:72
 * @route '/importar-alumnos-activos'
 */
        active_studentsForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: active_students.url(options),
            method: 'post',
        })
    
    active_students.form = active_studentsForm
/**
* @see \App\Http\Controllers\Admin\ImportController::grades
 * @see app/Http/Controllers/Admin/ImportController.php:53
 * @route '/importar-notas-proceso'
 */
export const grades = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: grades.url(options),
    method: 'post',
})

grades.definition = {
    methods: ["post"],
    url: '/importar-notas-proceso',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\ImportController::grades
 * @see app/Http/Controllers/Admin/ImportController.php:53
 * @route '/importar-notas-proceso'
 */
grades.url = (options?: RouteQueryOptions) => {
    return grades.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\ImportController::grades
 * @see app/Http/Controllers/Admin/ImportController.php:53
 * @route '/importar-notas-proceso'
 */
grades.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: grades.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\ImportController::grades
 * @see app/Http/Controllers/Admin/ImportController.php:53
 * @route '/importar-notas-proceso'
 */
    const gradesForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: grades.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\ImportController::grades
 * @see app/Http/Controllers/Admin/ImportController.php:53
 * @route '/importar-notas-proceso'
 */
        gradesForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: grades.url(options),
            method: 'post',
        })
    
    grades.form = gradesForm
const importMethod = {
    students: Object.assign(students, students),
courses: Object.assign(courses, courses),
active_students: Object.assign(active_students, active_students),
grades: Object.assign(grades, grades),
}

export default importMethod