import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Teacher\PracticeEvaluationController::index
 * @see app/Http/Controllers/Teacher/PracticeEvaluationController.php:15
 * @route '/docente/mis-practicantes'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/docente/mis-practicantes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Teacher\PracticeEvaluationController::index
 * @see app/Http/Controllers/Teacher/PracticeEvaluationController.php:15
 * @route '/docente/mis-practicantes'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Teacher\PracticeEvaluationController::index
 * @see app/Http/Controllers/Teacher/PracticeEvaluationController.php:15
 * @route '/docente/mis-practicantes'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Teacher\PracticeEvaluationController::index
 * @see app/Http/Controllers/Teacher/PracticeEvaluationController.php:15
 * @route '/docente/mis-practicantes'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Teacher\PracticeEvaluationController::index
 * @see app/Http/Controllers/Teacher/PracticeEvaluationController.php:15
 * @route '/docente/mis-practicantes'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Teacher\PracticeEvaluationController::index
 * @see app/Http/Controllers/Teacher/PracticeEvaluationController.php:15
 * @route '/docente/mis-practicantes'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Teacher\PracticeEvaluationController::index
 * @see app/Http/Controllers/Teacher/PracticeEvaluationController.php:15
 * @route '/docente/mis-practicantes'
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
* @see \App\Http\Controllers\Teacher\PracticeEvaluationController::store
 * @see app/Http/Controllers/Teacher/PracticeEvaluationController.php:29
 * @route '/docente/mis-practicantes/{assignment}/evaluar'
 */
export const store = (args: { assignment: number | { id: number } } | [assignment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/docente/mis-practicantes/{assignment}/evaluar',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Teacher\PracticeEvaluationController::store
 * @see app/Http/Controllers/Teacher/PracticeEvaluationController.php:29
 * @route '/docente/mis-practicantes/{assignment}/evaluar'
 */
store.url = (args: { assignment: number | { id: number } } | [assignment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { assignment: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { assignment: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    assignment: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        assignment: typeof args.assignment === 'object'
                ? args.assignment.id
                : args.assignment,
                }

    return store.definition.url
            .replace('{assignment}', parsedArgs.assignment.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Teacher\PracticeEvaluationController::store
 * @see app/Http/Controllers/Teacher/PracticeEvaluationController.php:29
 * @route '/docente/mis-practicantes/{assignment}/evaluar'
 */
store.post = (args: { assignment: number | { id: number } } | [assignment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Teacher\PracticeEvaluationController::store
 * @see app/Http/Controllers/Teacher/PracticeEvaluationController.php:29
 * @route '/docente/mis-practicantes/{assignment}/evaluar'
 */
    const storeForm = (args: { assignment: number | { id: number } } | [assignment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Teacher\PracticeEvaluationController::store
 * @see app/Http/Controllers/Teacher/PracticeEvaluationController.php:29
 * @route '/docente/mis-practicantes/{assignment}/evaluar'
 */
        storeForm.post = (args: { assignment: number | { id: number } } | [assignment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(args, options),
            method: 'post',
        })
    
    store.form = storeForm
const practice = {
    index: Object.assign(index, index),
store: Object.assign(store, store),
}

export default practice