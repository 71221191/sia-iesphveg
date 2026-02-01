import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
import progress from './progress'
import thesis from './thesis'
/**
* @see \App\Http\Controllers\Student\ThesisController::uploadDocument
 * @see app/Http/Controllers/Student/ThesisController.php:71
 * @route '/estudiante/{project}/documento'
 */
export const uploadDocument = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: uploadDocument.url(args, options),
    method: 'post',
})

uploadDocument.definition = {
    methods: ["post"],
    url: '/estudiante/{project}/documento',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Student\ThesisController::uploadDocument
 * @see app/Http/Controllers/Student/ThesisController.php:71
 * @route '/estudiante/{project}/documento'
 */
uploadDocument.url = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { project: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { project: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    project: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        project: typeof args.project === 'object'
                ? args.project.id
                : args.project,
                }

    return uploadDocument.definition.url
            .replace('{project}', parsedArgs.project.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Student\ThesisController::uploadDocument
 * @see app/Http/Controllers/Student/ThesisController.php:71
 * @route '/estudiante/{project}/documento'
 */
uploadDocument.post = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: uploadDocument.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Student\ThesisController::uploadDocument
 * @see app/Http/Controllers/Student/ThesisController.php:71
 * @route '/estudiante/{project}/documento'
 */
    const uploadDocumentForm = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: uploadDocument.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Student\ThesisController::uploadDocument
 * @see app/Http/Controllers/Student/ThesisController.php:71
 * @route '/estudiante/{project}/documento'
 */
        uploadDocumentForm.post = (args: { project: number | { id: number } } | [project: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: uploadDocument.url(args, options),
            method: 'post',
        })
    
    uploadDocument.form = uploadDocumentForm
const student = {
    progress: Object.assign(progress, progress),
uploadDocument: Object.assign(uploadDocument, uploadDocument),
thesis: Object.assign(thesis, thesis),
}

export default student