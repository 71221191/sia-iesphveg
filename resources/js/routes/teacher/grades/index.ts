import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Teacher\GradeController::store
 * @see app/Http/Controllers/Teacher/GradeController.php:21
 * @route '/docente/secciones/{section}/notas'
 */
export const store = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/docente/secciones/{section}/notas',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Teacher\GradeController::store
 * @see app/Http/Controllers/Teacher/GradeController.php:21
 * @route '/docente/secciones/{section}/notas'
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
* @see \App\Http\Controllers\Teacher\GradeController::store
 * @see app/Http/Controllers/Teacher/GradeController.php:21
 * @route '/docente/secciones/{section}/notas'
 */
store.post = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Teacher\GradeController::store
 * @see app/Http/Controllers/Teacher/GradeController.php:21
 * @route '/docente/secciones/{section}/notas'
 */
    const storeForm = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Teacher\GradeController::store
 * @see app/Http/Controllers/Teacher/GradeController.php:21
 * @route '/docente/secciones/{section}/notas'
 */
        storeForm.post = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(args, options),
            method: 'post',
        })
    
    store.form = storeForm
const grades = {
    store: Object.assign(store, store),
}

export default grades