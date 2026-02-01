import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Teacher\PortfolioController::index
 * @see app/Http/Controllers/Teacher/PortfolioController.php:14
 * @route '/docente/portafolio/seccion/{section}'
 */
export const index = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/docente/portafolio/seccion/{section}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Teacher\PortfolioController::index
 * @see app/Http/Controllers/Teacher/PortfolioController.php:14
 * @route '/docente/portafolio/seccion/{section}'
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
* @see \App\Http\Controllers\Teacher\PortfolioController::index
 * @see app/Http/Controllers/Teacher/PortfolioController.php:14
 * @route '/docente/portafolio/seccion/{section}'
 */
index.get = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Teacher\PortfolioController::index
 * @see app/Http/Controllers/Teacher/PortfolioController.php:14
 * @route '/docente/portafolio/seccion/{section}'
 */
index.head = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Teacher\PortfolioController::index
 * @see app/Http/Controllers/Teacher/PortfolioController.php:14
 * @route '/docente/portafolio/seccion/{section}'
 */
    const indexForm = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Teacher\PortfolioController::index
 * @see app/Http/Controllers/Teacher/PortfolioController.php:14
 * @route '/docente/portafolio/seccion/{section}'
 */
        indexForm.get = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Teacher\PortfolioController::index
 * @see app/Http/Controllers/Teacher/PortfolioController.php:14
 * @route '/docente/portafolio/seccion/{section}'
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
* @see \App\Http\Controllers\Teacher\PortfolioController::store
 * @see app/Http/Controllers/Teacher/PortfolioController.php:26
 * @route '/docente/portafolio/seccion/{section}/subir'
 */
export const store = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/docente/portafolio/seccion/{section}/subir',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Teacher\PortfolioController::store
 * @see app/Http/Controllers/Teacher/PortfolioController.php:26
 * @route '/docente/portafolio/seccion/{section}/subir'
 */
store.url = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return store.definition.url
            .replace('{section}', parsedArgs.section.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Teacher\PortfolioController::store
 * @see app/Http/Controllers/Teacher/PortfolioController.php:26
 * @route '/docente/portafolio/seccion/{section}/subir'
 */
store.post = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Teacher\PortfolioController::store
 * @see app/Http/Controllers/Teacher/PortfolioController.php:26
 * @route '/docente/portafolio/seccion/{section}/subir'
 */
    const storeForm = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Teacher\PortfolioController::store
 * @see app/Http/Controllers/Teacher/PortfolioController.php:26
 * @route '/docente/portafolio/seccion/{section}/subir'
 */
        storeForm.post = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(args, options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\Teacher\PortfolioController::destroy
 * @see app/Http/Controllers/Teacher/PortfolioController.php:51
 * @route '/docente/portafolio/archivo/{portfolio}'
 */
export const destroy = (args: { portfolio: number | { id: number } } | [portfolio: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/docente/portafolio/archivo/{portfolio}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Teacher\PortfolioController::destroy
 * @see app/Http/Controllers/Teacher/PortfolioController.php:51
 * @route '/docente/portafolio/archivo/{portfolio}'
 */
destroy.url = (args: { portfolio: number | { id: number } } | [portfolio: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { portfolio: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { portfolio: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    portfolio: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        portfolio: typeof args.portfolio === 'object'
                ? args.portfolio.id
                : args.portfolio,
                }

    return destroy.definition.url
            .replace('{portfolio}', parsedArgs.portfolio.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Teacher\PortfolioController::destroy
 * @see app/Http/Controllers/Teacher/PortfolioController.php:51
 * @route '/docente/portafolio/archivo/{portfolio}'
 */
destroy.delete = (args: { portfolio: number | { id: number } } | [portfolio: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\Teacher\PortfolioController::destroy
 * @see app/Http/Controllers/Teacher/PortfolioController.php:51
 * @route '/docente/portafolio/archivo/{portfolio}'
 */
    const destroyForm = (args: { portfolio: number | { id: number } } | [portfolio: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Teacher\PortfolioController::destroy
 * @see app/Http/Controllers/Teacher/PortfolioController.php:51
 * @route '/docente/portafolio/archivo/{portfolio}'
 */
        destroyForm.delete = (args: { portfolio: number | { id: number } } | [portfolio: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy.form = destroyForm
const portfolio = {
    index: Object.assign(index, index),
store: Object.assign(store, store),
destroy: Object.assign(destroy, destroy),
}

export default portfolio