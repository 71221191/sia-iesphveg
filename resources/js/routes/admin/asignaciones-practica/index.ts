import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\PracticeAssignmentController::index
 * @see app/Http/Controllers/Admin/PracticeAssignmentController.php:15
 * @route '/admin/asignaciones-practica'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/asignaciones-practica',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\PracticeAssignmentController::index
 * @see app/Http/Controllers/Admin/PracticeAssignmentController.php:15
 * @route '/admin/asignaciones-practica'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\PracticeAssignmentController::index
 * @see app/Http/Controllers/Admin/PracticeAssignmentController.php:15
 * @route '/admin/asignaciones-practica'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\PracticeAssignmentController::index
 * @see app/Http/Controllers/Admin/PracticeAssignmentController.php:15
 * @route '/admin/asignaciones-practica'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\PracticeAssignmentController::index
 * @see app/Http/Controllers/Admin/PracticeAssignmentController.php:15
 * @route '/admin/asignaciones-practica'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\PracticeAssignmentController::index
 * @see app/Http/Controllers/Admin/PracticeAssignmentController.php:15
 * @route '/admin/asignaciones-practica'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\PracticeAssignmentController::index
 * @see app/Http/Controllers/Admin/PracticeAssignmentController.php:15
 * @route '/admin/asignaciones-practica'
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
* @see \App\Http\Controllers\Admin\PracticeAssignmentController::store
 * @see app/Http/Controllers/Admin/PracticeAssignmentController.php:37
 * @route '/admin/asignaciones-practica'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/asignaciones-practica',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\PracticeAssignmentController::store
 * @see app/Http/Controllers/Admin/PracticeAssignmentController.php:37
 * @route '/admin/asignaciones-practica'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\PracticeAssignmentController::store
 * @see app/Http/Controllers/Admin/PracticeAssignmentController.php:37
 * @route '/admin/asignaciones-practica'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\PracticeAssignmentController::store
 * @see app/Http/Controllers/Admin/PracticeAssignmentController.php:37
 * @route '/admin/asignaciones-practica'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\PracticeAssignmentController::store
 * @see app/Http/Controllers/Admin/PracticeAssignmentController.php:37
 * @route '/admin/asignaciones-practica'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\Admin\PracticeAssignmentController::destroy
 * @see app/Http/Controllers/Admin/PracticeAssignmentController.php:62
 * @route '/admin/asignaciones-practica/{asignaciones_practica}'
 */
export const destroy = (args: { asignaciones_practica: string | number } | [asignaciones_practica: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/asignaciones-practica/{asignaciones_practica}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Admin\PracticeAssignmentController::destroy
 * @see app/Http/Controllers/Admin/PracticeAssignmentController.php:62
 * @route '/admin/asignaciones-practica/{asignaciones_practica}'
 */
destroy.url = (args: { asignaciones_practica: string | number } | [asignaciones_practica: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { asignaciones_practica: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    asignaciones_practica: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        asignaciones_practica: args.asignaciones_practica,
                }

    return destroy.definition.url
            .replace('{asignaciones_practica}', parsedArgs.asignaciones_practica.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\PracticeAssignmentController::destroy
 * @see app/Http/Controllers/Admin/PracticeAssignmentController.php:62
 * @route '/admin/asignaciones-practica/{asignaciones_practica}'
 */
destroy.delete = (args: { asignaciones_practica: string | number } | [asignaciones_practica: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\Admin\PracticeAssignmentController::destroy
 * @see app/Http/Controllers/Admin/PracticeAssignmentController.php:62
 * @route '/admin/asignaciones-practica/{asignaciones_practica}'
 */
    const destroyForm = (args: { asignaciones_practica: string | number } | [asignaciones_practica: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\PracticeAssignmentController::destroy
 * @see app/Http/Controllers/Admin/PracticeAssignmentController.php:62
 * @route '/admin/asignaciones-practica/{asignaciones_practica}'
 */
        destroyForm.delete = (args: { asignaciones_practica: string | number } | [asignaciones_practica: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy.form = destroyForm
const asignacionesPractica = {
    index: Object.assign(index, index),
store: Object.assign(store, store),
destroy: Object.assign(destroy, destroy),
}

export default asignacionesPractica