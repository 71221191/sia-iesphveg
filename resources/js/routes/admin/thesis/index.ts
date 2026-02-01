import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\ThesisController::index
 * @see app/Http/Controllers/Admin/ThesisController.php:13
 * @route '/admin/tesis'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/tesis',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\ThesisController::index
 * @see app/Http/Controllers/Admin/ThesisController.php:13
 * @route '/admin/tesis'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\ThesisController::index
 * @see app/Http/Controllers/Admin/ThesisController.php:13
 * @route '/admin/tesis'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\ThesisController::index
 * @see app/Http/Controllers/Admin/ThesisController.php:13
 * @route '/admin/tesis'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\ThesisController::index
 * @see app/Http/Controllers/Admin/ThesisController.php:13
 * @route '/admin/tesis'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\ThesisController::index
 * @see app/Http/Controllers/Admin/ThesisController.php:13
 * @route '/admin/tesis'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\ThesisController::index
 * @see app/Http/Controllers/Admin/ThesisController.php:13
 * @route '/admin/tesis'
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
* @see \App\Http\Controllers\Admin\ThesisController::show
 * @see app/Http/Controllers/Admin/ThesisController.php:33
 * @route '/admin/tesis/{project}'
 */
export const show = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/admin/tesis/{project}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\ThesisController::show
 * @see app/Http/Controllers/Admin/ThesisController.php:33
 * @route '/admin/tesis/{project}'
 */
show.url = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { project: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { project: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    project: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        project: typeof args.project === 'object'
                ? args.project.id
                : args.project,
                }

    return show.definition.url
            .replace('{project}', parsedArgs.project.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\ThesisController::show
 * @see app/Http/Controllers/Admin/ThesisController.php:33
 * @route '/admin/tesis/{project}'
 */
show.get = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\ThesisController::show
 * @see app/Http/Controllers/Admin/ThesisController.php:33
 * @route '/admin/tesis/{project}'
 */
show.head = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\ThesisController::show
 * @see app/Http/Controllers/Admin/ThesisController.php:33
 * @route '/admin/tesis/{project}'
 */
    const showForm = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\ThesisController::show
 * @see app/Http/Controllers/Admin/ThesisController.php:33
 * @route '/admin/tesis/{project}'
 */
        showForm.get = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\ThesisController::show
 * @see app/Http/Controllers/Admin/ThesisController.php:33
 * @route '/admin/tesis/{project}'
 */
        showForm.head = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Admin\ThesisController::assignAdvisor
 * @see app/Http/Controllers/Admin/ThesisController.php:48
 * @route '/admin/tesis/{project}/asesor'
 */
export const assignAdvisor = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: assignAdvisor.url(args, options),
    method: 'patch',
})

assignAdvisor.definition = {
    methods: ["patch"],
    url: '/admin/tesis/{project}/asesor',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Admin\ThesisController::assignAdvisor
 * @see app/Http/Controllers/Admin/ThesisController.php:48
 * @route '/admin/tesis/{project}/asesor'
 */
assignAdvisor.url = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { project: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { project: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    project: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        project: typeof args.project === 'object'
                ? args.project.id
                : args.project,
                }

    return assignAdvisor.definition.url
            .replace('{project}', parsedArgs.project.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\ThesisController::assignAdvisor
 * @see app/Http/Controllers/Admin/ThesisController.php:48
 * @route '/admin/tesis/{project}/asesor'
 */
assignAdvisor.patch = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: assignAdvisor.url(args, options),
    method: 'patch',
})

    /**
* @see \App\Http\Controllers\Admin\ThesisController::assignAdvisor
 * @see app/Http/Controllers/Admin/ThesisController.php:48
 * @route '/admin/tesis/{project}/asesor'
 */
    const assignAdvisorForm = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: assignAdvisor.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PATCH',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\ThesisController::assignAdvisor
 * @see app/Http/Controllers/Admin/ThesisController.php:48
 * @route '/admin/tesis/{project}/asesor'
 */
        assignAdvisorForm.patch = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: assignAdvisor.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PATCH',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    assignAdvisor.form = assignAdvisorForm
/**
* @see \App\Http\Controllers\Admin\ThesisController::assignJurors
 * @see app/Http/Controllers/Admin/ThesisController.php:61
 * @route '/admin/tesis/{project}/jurados'
 */
export const assignJurors = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: assignJurors.url(args, options),
    method: 'post',
})

assignJurors.definition = {
    methods: ["post"],
    url: '/admin/tesis/{project}/jurados',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\ThesisController::assignJurors
 * @see app/Http/Controllers/Admin/ThesisController.php:61
 * @route '/admin/tesis/{project}/jurados'
 */
assignJurors.url = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { project: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { project: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    project: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        project: typeof args.project === 'object'
                ? args.project.id
                : args.project,
                }

    return assignJurors.definition.url
            .replace('{project}', parsedArgs.project.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\ThesisController::assignJurors
 * @see app/Http/Controllers/Admin/ThesisController.php:61
 * @route '/admin/tesis/{project}/jurados'
 */
assignJurors.post = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: assignJurors.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\ThesisController::assignJurors
 * @see app/Http/Controllers/Admin/ThesisController.php:61
 * @route '/admin/tesis/{project}/jurados'
 */
    const assignJurorsForm = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: assignJurors.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\ThesisController::assignJurors
 * @see app/Http/Controllers/Admin/ThesisController.php:61
 * @route '/admin/tesis/{project}/jurados'
 */
        assignJurorsForm.post = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: assignJurors.url(args, options),
            method: 'post',
        })
    
    assignJurors.form = assignJurorsForm
/**
* @see \App\Http\Controllers\Admin\ThesisController::recordDefense
 * @see app/Http/Controllers/Admin/ThesisController.php:90
 * @route '/admin/tesis/{project}/sustentacion'
 */
export const recordDefense = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: recordDefense.url(args, options),
    method: 'post',
})

recordDefense.definition = {
    methods: ["post"],
    url: '/admin/tesis/{project}/sustentacion',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\ThesisController::recordDefense
 * @see app/Http/Controllers/Admin/ThesisController.php:90
 * @route '/admin/tesis/{project}/sustentacion'
 */
recordDefense.url = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { project: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { project: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    project: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        project: typeof args.project === 'object'
                ? args.project.id
                : args.project,
                }

    return recordDefense.definition.url
            .replace('{project}', parsedArgs.project.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\ThesisController::recordDefense
 * @see app/Http/Controllers/Admin/ThesisController.php:90
 * @route '/admin/tesis/{project}/sustentacion'
 */
recordDefense.post = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: recordDefense.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\ThesisController::recordDefense
 * @see app/Http/Controllers/Admin/ThesisController.php:90
 * @route '/admin/tesis/{project}/sustentacion'
 */
    const recordDefenseForm = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: recordDefense.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\ThesisController::recordDefense
 * @see app/Http/Controllers/Admin/ThesisController.php:90
 * @route '/admin/tesis/{project}/sustentacion'
 */
        recordDefenseForm.post = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: recordDefense.url(args, options),
            method: 'post',
        })
    
    recordDefense.form = recordDefenseForm
const thesis = {
    index: Object.assign(index, index),
show: Object.assign(show, show),
assignAdvisor: Object.assign(assignAdvisor, assignAdvisor),
assignJurors: Object.assign(assignJurors, assignJurors),
recordDefense: Object.assign(recordDefense, recordDefense),
}

export default thesis