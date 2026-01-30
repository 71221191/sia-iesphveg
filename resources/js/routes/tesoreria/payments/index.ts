import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\TreasuryController::index
 * @see app/Http/Controllers/TreasuryController.php:13
 * @route '/tesoreria/validar-pagos'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/tesoreria/validar-pagos',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\TreasuryController::index
 * @see app/Http/Controllers/TreasuryController.php:13
 * @route '/tesoreria/validar-pagos'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\TreasuryController::index
 * @see app/Http/Controllers/TreasuryController.php:13
 * @route '/tesoreria/validar-pagos'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\TreasuryController::index
 * @see app/Http/Controllers/TreasuryController.php:13
 * @route '/tesoreria/validar-pagos'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\TreasuryController::index
 * @see app/Http/Controllers/TreasuryController.php:13
 * @route '/tesoreria/validar-pagos'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\TreasuryController::index
 * @see app/Http/Controllers/TreasuryController.php:13
 * @route '/tesoreria/validar-pagos'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\TreasuryController::index
 * @see app/Http/Controllers/TreasuryController.php:13
 * @route '/tesoreria/validar-pagos'
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
* @see \App\Http\Controllers\TreasuryController::verify
 * @see app/Http/Controllers/TreasuryController.php:30
 * @route '/tesoreria/pagos/{payment}/verify'
 */
export const verify = (args: { payment: number | { id: number } } | [payment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: verify.url(args, options),
    method: 'patch',
})

verify.definition = {
    methods: ["patch"],
    url: '/tesoreria/pagos/{payment}/verify',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\TreasuryController::verify
 * @see app/Http/Controllers/TreasuryController.php:30
 * @route '/tesoreria/pagos/{payment}/verify'
 */
verify.url = (args: { payment: number | { id: number } } | [payment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { payment: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { payment: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    payment: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        payment: typeof args.payment === 'object'
                ? args.payment.id
                : args.payment,
                }

    return verify.definition.url
            .replace('{payment}', parsedArgs.payment.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\TreasuryController::verify
 * @see app/Http/Controllers/TreasuryController.php:30
 * @route '/tesoreria/pagos/{payment}/verify'
 */
verify.patch = (args: { payment: number | { id: number } } | [payment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: verify.url(args, options),
    method: 'patch',
})

    /**
* @see \App\Http\Controllers\TreasuryController::verify
 * @see app/Http/Controllers/TreasuryController.php:30
 * @route '/tesoreria/pagos/{payment}/verify'
 */
    const verifyForm = (args: { payment: number | { id: number } } | [payment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: verify.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PATCH',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\TreasuryController::verify
 * @see app/Http/Controllers/TreasuryController.php:30
 * @route '/tesoreria/pagos/{payment}/verify'
 */
        verifyForm.patch = (args: { payment: number | { id: number } } | [payment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: verify.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PATCH',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    verify.form = verifyForm
const payments = {
    index: Object.assign(index, index),
verify: Object.assign(verify, verify),
}

export default payments