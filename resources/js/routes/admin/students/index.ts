import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\StudentController::index
 * @see app/Http/Controllers/Admin/StudentController.php:12
 * @route '/admin/estudiantes'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/estudiantes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\StudentController::index
 * @see app/Http/Controllers/Admin/StudentController.php:12
 * @route '/admin/estudiantes'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\StudentController::index
 * @see app/Http/Controllers/Admin/StudentController.php:12
 * @route '/admin/estudiantes'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\StudentController::index
 * @see app/Http/Controllers/Admin/StudentController.php:12
 * @route '/admin/estudiantes'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\StudentController::index
 * @see app/Http/Controllers/Admin/StudentController.php:12
 * @route '/admin/estudiantes'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\StudentController::index
 * @see app/Http/Controllers/Admin/StudentController.php:12
 * @route '/admin/estudiantes'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\StudentController::index
 * @see app/Http/Controllers/Admin/StudentController.php:12
 * @route '/admin/estudiantes'
 */
        indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    index.form = indexForm
/**
* @see \App\Http\Controllers\Admin\StudentController::show
 * @see app/Http/Controllers/Admin/StudentController.php:33
 * @route '/admin/estudiantes/{id}'
 */
export const show = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/admin/estudiantes/{id}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\StudentController::show
 * @see app/Http/Controllers/Admin/StudentController.php:33
 * @route '/admin/estudiantes/{id}'
 */
show.url = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { id: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    id: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        id: args.id,
                }

    return show.definition.url
            .replace('{id}', parsedArgs.id.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\StudentController::show
 * @see app/Http/Controllers/Admin/StudentController.php:33
 * @route '/admin/estudiantes/{id}'
 */
show.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\StudentController::show
 * @see app/Http/Controllers/Admin/StudentController.php:33
 * @route '/admin/estudiantes/{id}'
 */
show.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\StudentController::show
 * @see app/Http/Controllers/Admin/StudentController.php:33
 * @route '/admin/estudiantes/{id}'
 */
    const showForm = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\StudentController::show
 * @see app/Http/Controllers/Admin/StudentController.php:33
 * @route '/admin/estudiantes/{id}'
 */
        showForm.get = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\StudentController::show
 * @see app/Http/Controllers/Admin/StudentController.php:33
 * @route '/admin/estudiantes/{id}'
 */
        showForm.head = (args: { id: string | number } | [id: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    show.form = showForm
/**
* @see \App\Http\Controllers\ReportController::certificate
 * @see app/Http/Controllers/ReportController.php:22
 * @route '/admin/estudiantes/{personId}/certificado'
 */
export const certificate = (args: { personId: string | number } | [personId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: certificate.url(args, options),
    method: 'get',
})

certificate.definition = {
    methods: ["get","head"],
    url: '/admin/estudiantes/{personId}/certificado',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ReportController::certificate
 * @see app/Http/Controllers/ReportController.php:22
 * @route '/admin/estudiantes/{personId}/certificado'
 */
certificate.url = (args: { personId: string | number } | [personId: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { personId: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    personId: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        personId: args.personId,
                }

    return certificate.definition.url
            .replace('{personId}', parsedArgs.personId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ReportController::certificate
 * @see app/Http/Controllers/ReportController.php:22
 * @route '/admin/estudiantes/{personId}/certificado'
 */
certificate.get = (args: { personId: string | number } | [personId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: certificate.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\ReportController::certificate
 * @see app/Http/Controllers/ReportController.php:22
 * @route '/admin/estudiantes/{personId}/certificado'
 */
certificate.head = (args: { personId: string | number } | [personId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: certificate.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\ReportController::certificate
 * @see app/Http/Controllers/ReportController.php:22
 * @route '/admin/estudiantes/{personId}/certificado'
 */
    const certificateForm = (args: { personId: string | number } | [personId: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: certificate.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\ReportController::certificate
 * @see app/Http/Controllers/ReportController.php:22
 * @route '/admin/estudiantes/{personId}/certificado'
 */
        certificateForm.get = (args: { personId: string | number } | [personId: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: certificate.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\ReportController::certificate
 * @see app/Http/Controllers/ReportController.php:22
 * @route '/admin/estudiantes/{personId}/certificado'
 */
        certificateForm.head = (args: { personId: string | number } | [personId: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: certificate.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    certificate.form = certificateForm
const students = {
    index: Object.assign(index, index),
show: Object.assign(show, show),
certificate: Object.assign(certificate, certificate),
}

export default students