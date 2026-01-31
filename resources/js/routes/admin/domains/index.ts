import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\DomainController::store
 * @see app/Http/Controllers/Admin/DomainController.php:11
 * @route '/admin/dominios'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/dominios',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\DomainController::store
 * @see app/Http/Controllers/Admin/DomainController.php:11
 * @route '/admin/dominios'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\DomainController::store
 * @see app/Http/Controllers/Admin/DomainController.php:11
 * @route '/admin/dominios'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\DomainController::store
 * @see app/Http/Controllers/Admin/DomainController.php:11
 * @route '/admin/dominios'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\DomainController::store
 * @see app/Http/Controllers/Admin/DomainController.php:11
 * @route '/admin/dominios'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\Admin\DomainController::destroy
 * @see app/Http/Controllers/Admin/DomainController.php:33
 * @route '/admin/dominios/{domain}'
 */
export const destroy = (args: { domain: number | { id: number } } | [domain: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/dominios/{domain}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Admin\DomainController::destroy
 * @see app/Http/Controllers/Admin/DomainController.php:33
 * @route '/admin/dominios/{domain}'
 */
destroy.url = (args: { domain: number | { id: number } } | [domain: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { domain: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { domain: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    domain: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        domain: typeof args.domain === 'object'
                ? args.domain.id
                : args.domain,
                }

    return destroy.definition.url
            .replace('{domain}', parsedArgs.domain.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\DomainController::destroy
 * @see app/Http/Controllers/Admin/DomainController.php:33
 * @route '/admin/dominios/{domain}'
 */
destroy.delete = (args: { domain: number | { id: number } } | [domain: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\Admin\DomainController::destroy
 * @see app/Http/Controllers/Admin/DomainController.php:33
 * @route '/admin/dominios/{domain}'
 */
    const destroyForm = (args: { domain: number | { id: number } } | [domain: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\DomainController::destroy
 * @see app/Http/Controllers/Admin/DomainController.php:33
 * @route '/admin/dominios/{domain}'
 */
        destroyForm.delete = (args: { domain: number | { id: number } } | [domain: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy.form = destroyForm
const domains = {
    store: Object.assign(store, store),
destroy: Object.assign(destroy, destroy),
}

export default domains