import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Teacher\AttendanceController::index
 * @see app/Http/Controllers/Teacher/AttendanceController.php:21
 * @route '/docente/asistencia/seccion/{section}'
 */
export const index = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/docente/asistencia/seccion/{section}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Teacher\AttendanceController::index
 * @see app/Http/Controllers/Teacher/AttendanceController.php:21
 * @route '/docente/asistencia/seccion/{section}'
 */
index.url = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { section: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { section: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    section: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        section: typeof args.section === 'object'
                ? args.section.id
                : args.section,
                }

    return index.definition.url
            .replace('{section}', parsedArgs.section.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Teacher\AttendanceController::index
 * @see app/Http/Controllers/Teacher/AttendanceController.php:21
 * @route '/docente/asistencia/seccion/{section}'
 */
index.get = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Teacher\AttendanceController::index
 * @see app/Http/Controllers/Teacher/AttendanceController.php:21
 * @route '/docente/asistencia/seccion/{section}'
 */
index.head = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Teacher\AttendanceController::index
 * @see app/Http/Controllers/Teacher/AttendanceController.php:21
 * @route '/docente/asistencia/seccion/{section}'
 */
    const indexForm = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Teacher\AttendanceController::index
 * @see app/Http/Controllers/Teacher/AttendanceController.php:21
 * @route '/docente/asistencia/seccion/{section}'
 */
        indexForm.get = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Teacher\AttendanceController::index
 * @see app/Http/Controllers/Teacher/AttendanceController.php:21
 * @route '/docente/asistencia/seccion/{section}'
 */
        indexForm.head = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    index.form = indexForm
/**
* @see \App\Http\Controllers\Teacher\AttendanceController::storeSession
 * @see app/Http/Controllers/Teacher/AttendanceController.php:44
 * @route '/docente/asistencia/seccion/{section}/sesion'
 */
export const storeSession = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeSession.url(args, options),
    method: 'post',
})

storeSession.definition = {
    methods: ["post"],
    url: '/docente/asistencia/seccion/{section}/sesion',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Teacher\AttendanceController::storeSession
 * @see app/Http/Controllers/Teacher/AttendanceController.php:44
 * @route '/docente/asistencia/seccion/{section}/sesion'
 */
storeSession.url = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { section: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { section: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    section: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        section: typeof args.section === 'object'
                ? args.section.id
                : args.section,
                }

    return storeSession.definition.url
            .replace('{section}', parsedArgs.section.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Teacher\AttendanceController::storeSession
 * @see app/Http/Controllers/Teacher/AttendanceController.php:44
 * @route '/docente/asistencia/seccion/{section}/sesion'
 */
storeSession.post = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeSession.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Teacher\AttendanceController::storeSession
 * @see app/Http/Controllers/Teacher/AttendanceController.php:44
 * @route '/docente/asistencia/seccion/{section}/sesion'
 */
    const storeSessionForm = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: storeSession.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Teacher\AttendanceController::storeSession
 * @see app/Http/Controllers/Teacher/AttendanceController.php:44
 * @route '/docente/asistencia/seccion/{section}/sesion'
 */
        storeSessionForm.post = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: storeSession.url(args, options),
            method: 'post',
        })
    
    storeSession.form = storeSessionForm
/**
* @see \App\Http\Controllers\Teacher\AttendanceController::show
 * @see app/Http/Controllers/Teacher/AttendanceController.php:32
 * @route '/docente/asistencia/sesion/{session}'
 */
export const show = (args: { session: number | { id: number } } | [session: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/docente/asistencia/sesion/{session}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Teacher\AttendanceController::show
 * @see app/Http/Controllers/Teacher/AttendanceController.php:32
 * @route '/docente/asistencia/sesion/{session}'
 */
show.url = (args: { session: number | { id: number } } | [session: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { session: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { session: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    session: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        session: typeof args.session === 'object'
                ? args.session.id
                : args.session,
                }

    return show.definition.url
            .replace('{session}', parsedArgs.session.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Teacher\AttendanceController::show
 * @see app/Http/Controllers/Teacher/AttendanceController.php:32
 * @route '/docente/asistencia/sesion/{session}'
 */
show.get = (args: { session: number | { id: number } } | [session: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Teacher\AttendanceController::show
 * @see app/Http/Controllers/Teacher/AttendanceController.php:32
 * @route '/docente/asistencia/sesion/{session}'
 */
show.head = (args: { session: number | { id: number } } | [session: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Teacher\AttendanceController::show
 * @see app/Http/Controllers/Teacher/AttendanceController.php:32
 * @route '/docente/asistencia/sesion/{session}'
 */
    const showForm = (args: { session: number | { id: number } } | [session: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Teacher\AttendanceController::show
 * @see app/Http/Controllers/Teacher/AttendanceController.php:32
 * @route '/docente/asistencia/sesion/{session}'
 */
        showForm.get = (args: { session: number | { id: number } } | [session: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Teacher\AttendanceController::show
 * @see app/Http/Controllers/Teacher/AttendanceController.php:32
 * @route '/docente/asistencia/sesion/{session}'
 */
        showForm.head = (args: { session: number | { id: number } } | [session: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Teacher\AttendanceController::storeRecords
 * @see app/Http/Controllers/Teacher/AttendanceController.php:62
 * @route '/docente/asistencia/sesion/{session}/registrar'
 */
export const storeRecords = (args: { session: number | { id: number } } | [session: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeRecords.url(args, options),
    method: 'post',
})

storeRecords.definition = {
    methods: ["post"],
    url: '/docente/asistencia/sesion/{session}/registrar',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Teacher\AttendanceController::storeRecords
 * @see app/Http/Controllers/Teacher/AttendanceController.php:62
 * @route '/docente/asistencia/sesion/{session}/registrar'
 */
storeRecords.url = (args: { session: number | { id: number } } | [session: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { session: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { session: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    session: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        session: typeof args.session === 'object'
                ? args.session.id
                : args.session,
                }

    return storeRecords.definition.url
            .replace('{session}', parsedArgs.session.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Teacher\AttendanceController::storeRecords
 * @see app/Http/Controllers/Teacher/AttendanceController.php:62
 * @route '/docente/asistencia/sesion/{session}/registrar'
 */
storeRecords.post = (args: { session: number | { id: number } } | [session: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: storeRecords.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Teacher\AttendanceController::storeRecords
 * @see app/Http/Controllers/Teacher/AttendanceController.php:62
 * @route '/docente/asistencia/sesion/{session}/registrar'
 */
    const storeRecordsForm = (args: { session: number | { id: number } } | [session: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: storeRecords.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Teacher\AttendanceController::storeRecords
 * @see app/Http/Controllers/Teacher/AttendanceController.php:62
 * @route '/docente/asistencia/sesion/{session}/registrar'
 */
        storeRecordsForm.post = (args: { session: number | { id: number } } | [session: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: storeRecords.url(args, options),
            method: 'post',
        })
    
    storeRecords.form = storeRecordsForm
const attendance = {
    index: Object.assign(index, index),
storeSession: Object.assign(storeSession, storeSession),
show: Object.assign(show, show),
storeRecords: Object.assign(storeRecords, storeRecords),
}

export default attendance