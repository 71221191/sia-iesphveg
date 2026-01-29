import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\SocioeconomicController::create
 * @see app/Http/Controllers/SocioeconomicController.php:19
 * @route '/ficha-socioeconomica'
 */
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/ficha-socioeconomica',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\SocioeconomicController::create
 * @see app/Http/Controllers/SocioeconomicController.php:19
 * @route '/ficha-socioeconomica'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SocioeconomicController::create
 * @see app/Http/Controllers/SocioeconomicController.php:19
 * @route '/ficha-socioeconomica'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\SocioeconomicController::create
 * @see app/Http/Controllers/SocioeconomicController.php:19
 * @route '/ficha-socioeconomica'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\SocioeconomicController::create
 * @see app/Http/Controllers/SocioeconomicController.php:19
 * @route '/ficha-socioeconomica'
 */
    const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: create.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\SocioeconomicController::create
 * @see app/Http/Controllers/SocioeconomicController.php:19
 * @route '/ficha-socioeconomica'
 */
        createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: create.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\SocioeconomicController::create
 * @see app/Http/Controllers/SocioeconomicController.php:19
 * @route '/ficha-socioeconomica'
 */
        createForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: create.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    create.form = createForm
/**
* @see \App\Http\Controllers\SocioeconomicController::store
 * @see app/Http/Controllers/SocioeconomicController.php:115
 * @route '/ficha-socioeconomica'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/ficha-socioeconomica',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\SocioeconomicController::store
 * @see app/Http/Controllers/SocioeconomicController.php:115
 * @route '/ficha-socioeconomica'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SocioeconomicController::store
 * @see app/Http/Controllers/SocioeconomicController.php:115
 * @route '/ficha-socioeconomica'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\SocioeconomicController::store
 * @see app/Http/Controllers/SocioeconomicController.php:115
 * @route '/ficha-socioeconomica'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\SocioeconomicController::store
 * @see app/Http/Controllers/SocioeconomicController.php:115
 * @route '/ficha-socioeconomica'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
const socioeconomic = {
    create: Object.assign(create, create),
store: Object.assign(store, store),
}

export default socioeconomic