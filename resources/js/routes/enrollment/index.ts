import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\EnrollmentController::create
 * @see app/Http/Controllers/EnrollmentController.php:35
 * @route '/matricula'
 */
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/matricula',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\EnrollmentController::create
 * @see app/Http/Controllers/EnrollmentController.php:35
 * @route '/matricula'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\EnrollmentController::create
 * @see app/Http/Controllers/EnrollmentController.php:35
 * @route '/matricula'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\EnrollmentController::create
 * @see app/Http/Controllers/EnrollmentController.php:35
 * @route '/matricula'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\EnrollmentController::create
 * @see app/Http/Controllers/EnrollmentController.php:35
 * @route '/matricula'
 */
    const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: create.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\EnrollmentController::create
 * @see app/Http/Controllers/EnrollmentController.php:35
 * @route '/matricula'
 */
        createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: create.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\EnrollmentController::create
 * @see app/Http/Controllers/EnrollmentController.php:35
 * @route '/matricula'
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
* @see \App\Http\Controllers\EnrollmentController::store
 * @see app/Http/Controllers/EnrollmentController.php:64
 * @route '/matricula'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/matricula',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\EnrollmentController::store
 * @see app/Http/Controllers/EnrollmentController.php:64
 * @route '/matricula'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\EnrollmentController::store
 * @see app/Http/Controllers/EnrollmentController.php:64
 * @route '/matricula'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\EnrollmentController::store
 * @see app/Http/Controllers/EnrollmentController.php:64
 * @route '/matricula'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\EnrollmentController::store
 * @see app/Http/Controllers/EnrollmentController.php:64
 * @route '/matricula'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
const enrollment = {
    create: Object.assign(create, create),
store: Object.assign(store, store),
}

export default enrollment