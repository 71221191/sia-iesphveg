import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\CompetencyController::update
 * @see app/Http/Controllers/Admin/CompetencyController.php:33
 * @route '/docente/competencias/{competency}'
 */
export const update = (args: { competency: number | { id: number } } | [competency: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/docente/competencias/{competency}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Admin\CompetencyController::update
 * @see app/Http/Controllers/Admin/CompetencyController.php:33
 * @route '/docente/competencias/{competency}'
 */
update.url = (args: { competency: number | { id: number } } | [competency: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { competency: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { competency: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    competency: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        competency: typeof args.competency === 'object'
                ? args.competency.id
                : args.competency,
                }

    return update.definition.url
            .replace('{competency}', parsedArgs.competency.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\CompetencyController::update
 * @see app/Http/Controllers/Admin/CompetencyController.php:33
 * @route '/docente/competencias/{competency}'
 */
update.put = (args: { competency: number | { id: number } } | [competency: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

    /**
* @see \App\Http\Controllers\Admin\CompetencyController::update
 * @see app/Http/Controllers/Admin/CompetencyController.php:33
 * @route '/docente/competencias/{competency}'
 */
    const updateForm = (args: { competency: number | { id: number } } | [competency: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\CompetencyController::update
 * @see app/Http/Controllers/Admin/CompetencyController.php:33
 * @route '/docente/competencias/{competency}'
 */
        updateForm.put = (args: { competency: number | { id: number } } | [competency: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    update.form = updateForm
const competencies = {
    update: Object.assign(update, update),
}

export default competencies