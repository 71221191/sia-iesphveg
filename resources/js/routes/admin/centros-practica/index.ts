import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\PracticeCenterController::index
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:13
 * @route '/admin/centros-practica'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/centros-practica',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\PracticeCenterController::index
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:13
 * @route '/admin/centros-practica'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\PracticeCenterController::index
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:13
 * @route '/admin/centros-practica'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\PracticeCenterController::index
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:13
 * @route '/admin/centros-practica'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\PracticeCenterController::index
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:13
 * @route '/admin/centros-practica'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\PracticeCenterController::index
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:13
 * @route '/admin/centros-practica'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\PracticeCenterController::index
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:13
 * @route '/admin/centros-practica'
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
* @see \App\Http\Controllers\Admin\PracticeCenterController::store
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:22
 * @route '/admin/centros-practica'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/centros-practica',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\PracticeCenterController::store
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:22
 * @route '/admin/centros-practica'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\PracticeCenterController::store
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:22
 * @route '/admin/centros-practica'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\PracticeCenterController::store
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:22
 * @route '/admin/centros-practica'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\PracticeCenterController::store
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:22
 * @route '/admin/centros-practica'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\Admin\PracticeCenterController::update
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:37
 * @route '/admin/centros-practica/{centros_practica}'
 */
export const update = (args: { centros_practica: string | number } | [centros_practica: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/admin/centros-practica/{centros_practica}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Admin\PracticeCenterController::update
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:37
 * @route '/admin/centros-practica/{centros_practica}'
 */
update.url = (args: { centros_practica: string | number } | [centros_practica: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { centros_practica: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    centros_practica: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        centros_practica: args.centros_practica,
                }

    return update.definition.url
            .replace('{centros_practica}', parsedArgs.centros_practica.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\PracticeCenterController::update
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:37
 * @route '/admin/centros-practica/{centros_practica}'
 */
update.put = (args: { centros_practica: string | number } | [centros_practica: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\Admin\PracticeCenterController::update
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:37
 * @route '/admin/centros-practica/{centros_practica}'
 */
update.patch = (args: { centros_practica: string | number } | [centros_practica: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

    /**
* @see \App\Http\Controllers\Admin\PracticeCenterController::update
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:37
 * @route '/admin/centros-practica/{centros_practica}'
 */
    const updateForm = (args: { centros_practica: string | number } | [centros_practica: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\PracticeCenterController::update
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:37
 * @route '/admin/centros-practica/{centros_practica}'
 */
        updateForm.put = (args: { centros_practica: string | number } | [centros_practica: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
            /**
* @see \App\Http\Controllers\Admin\PracticeCenterController::update
 * @see app/Http/Controllers/Admin/PracticeCenterController.php:37
 * @route '/admin/centros-practica/{centros_practica}'
 */
        updateForm.patch = (args: { centros_practica: string | number } | [centros_practica: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PATCH',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    update.form = updateForm
const centrosPractica = {
    index: Object.assign(index, index),
store: Object.assign(store, store),
update: Object.assign(update, update),
}

export default centrosPractica