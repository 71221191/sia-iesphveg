import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Student\ProgressController::index
 * @see app/Http/Controllers/Student/ProgressController.php:21
 * @route '/estudiante/mi-progreso'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/estudiante/mi-progreso',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Student\ProgressController::index
 * @see app/Http/Controllers/Student/ProgressController.php:21
 * @route '/estudiante/mi-progreso'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Student\ProgressController::index
 * @see app/Http/Controllers/Student/ProgressController.php:21
 * @route '/estudiante/mi-progreso'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Student\ProgressController::index
 * @see app/Http/Controllers/Student/ProgressController.php:21
 * @route '/estudiante/mi-progreso'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Student\ProgressController::index
 * @see app/Http/Controllers/Student/ProgressController.php:21
 * @route '/estudiante/mi-progreso'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Student\ProgressController::index
 * @see app/Http/Controllers/Student/ProgressController.php:21
 * @route '/estudiante/mi-progreso'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Student\ProgressController::index
 * @see app/Http/Controllers/Student/ProgressController.php:21
 * @route '/estudiante/mi-progreso'
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
const progress = {
    index: Object.assign(index, index),
}

export default progress