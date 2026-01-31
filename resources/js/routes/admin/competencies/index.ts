import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\CompetencyController::index
 * @see app/Http/Controllers/Admin/CompetencyController.php:13
 * @route '/admin/competencias'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/competencias',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\CompetencyController::index
 * @see app/Http/Controllers/Admin/CompetencyController.php:13
 * @route '/admin/competencias'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\CompetencyController::index
 * @see app/Http/Controllers/Admin/CompetencyController.php:13
 * @route '/admin/competencias'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\CompetencyController::index
 * @see app/Http/Controllers/Admin/CompetencyController.php:13
 * @route '/admin/competencias'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\CompetencyController::index
 * @see app/Http/Controllers/Admin/CompetencyController.php:13
 * @route '/admin/competencias'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\CompetencyController::index
 * @see app/Http/Controllers/Admin/CompetencyController.php:13
 * @route '/admin/competencias'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\CompetencyController::index
 * @see app/Http/Controllers/Admin/CompetencyController.php:13
 * @route '/admin/competencias'
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
* @see \App\Http\Controllers\Admin\CompetencyController::store
 * @see app/Http/Controllers/Admin/CompetencyController.php:21
 * @route '/admin/competencias'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/competencias',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\CompetencyController::store
 * @see app/Http/Controllers/Admin/CompetencyController.php:21
 * @route '/admin/competencias'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\CompetencyController::store
 * @see app/Http/Controllers/Admin/CompetencyController.php:21
 * @route '/admin/competencias'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\CompetencyController::store
 * @see app/Http/Controllers/Admin/CompetencyController.php:21
 * @route '/admin/competencias'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\CompetencyController::store
 * @see app/Http/Controllers/Admin/CompetencyController.php:21
 * @route '/admin/competencias'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
const competencies = {
    index: Object.assign(index, index),
store: Object.assign(store, store),
}

export default competencies