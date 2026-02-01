import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\HeadOfArea\PortfolioValidationController::index
 * @see app/Http/Controllers/HeadOfArea/PortfolioValidationController.php:13
 * @route '/jefe-area/validar-portafolio'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/jefe-area/validar-portafolio',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\HeadOfArea\PortfolioValidationController::index
 * @see app/Http/Controllers/HeadOfArea/PortfolioValidationController.php:13
 * @route '/jefe-area/validar-portafolio'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\HeadOfArea\PortfolioValidationController::index
 * @see app/Http/Controllers/HeadOfArea/PortfolioValidationController.php:13
 * @route '/jefe-area/validar-portafolio'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\HeadOfArea\PortfolioValidationController::index
 * @see app/Http/Controllers/HeadOfArea/PortfolioValidationController.php:13
 * @route '/jefe-area/validar-portafolio'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\HeadOfArea\PortfolioValidationController::index
 * @see app/Http/Controllers/HeadOfArea/PortfolioValidationController.php:13
 * @route '/jefe-area/validar-portafolio'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\HeadOfArea\PortfolioValidationController::index
 * @see app/Http/Controllers/HeadOfArea/PortfolioValidationController.php:13
 * @route '/jefe-area/validar-portafolio'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\HeadOfArea\PortfolioValidationController::index
 * @see app/Http/Controllers/HeadOfArea/PortfolioValidationController.php:13
 * @route '/jefe-area/validar-portafolio'
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
* @see \App\Http\Controllers\HeadOfArea\PortfolioValidationController::update
 * @see app/Http/Controllers/HeadOfArea/PortfolioValidationController.php:30
 * @route '/jefe-area/validar-portafolio/{portfolio}'
 */
export const update = (args: { portfolio: number | { id: number } } | [portfolio: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/jefe-area/validar-portafolio/{portfolio}',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\HeadOfArea\PortfolioValidationController::update
 * @see app/Http/Controllers/HeadOfArea/PortfolioValidationController.php:30
 * @route '/jefe-area/validar-portafolio/{portfolio}'
 */
update.url = (args: { portfolio: number | { id: number } } | [portfolio: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{portfolio}', parsedArgs.portfolio.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\HeadOfArea\PortfolioValidationController::update
 * @see app/Http/Controllers/HeadOfArea/PortfolioValidationController.php:30
 * @route '/jefe-area/validar-portafolio/{portfolio}'
 */
update.patch = (args: { portfolio: number | { id: number } } | [portfolio: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

    /**
* @see \App\Http\Controllers\HeadOfArea\PortfolioValidationController::update
 * @see app/Http/Controllers/HeadOfArea/PortfolioValidationController.php:30
 * @route '/jefe-area/validar-portafolio/{portfolio}'
 */
    const updateForm = (args: { portfolio: number | { id: number } } | [portfolio: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PATCH',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\HeadOfArea\PortfolioValidationController::update
 * @see app/Http/Controllers/HeadOfArea/PortfolioValidationController.php:30
 * @route '/jefe-area/validar-portafolio/{portfolio}'
 */
        updateForm.patch = (args: { portfolio: number | { id: number } } | [portfolio: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PATCH',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    update.form = updateForm
const portfolio = {
    index: Object.assign(index, index),
update: Object.assign(update, update),
}

export default portfolio