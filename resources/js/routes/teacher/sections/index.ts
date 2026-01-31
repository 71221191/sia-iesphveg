import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Teacher\SectionController::index
 * @see app/Http/Controllers/Teacher/SectionController.php:22
 * @route '/docente/secciones'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/docente/secciones',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Teacher\SectionController::index
 * @see app/Http/Controllers/Teacher/SectionController.php:22
 * @route '/docente/secciones'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Teacher\SectionController::index
 * @see app/Http/Controllers/Teacher/SectionController.php:22
 * @route '/docente/secciones'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Teacher\SectionController::index
 * @see app/Http/Controllers/Teacher/SectionController.php:22
 * @route '/docente/secciones'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Teacher\SectionController::index
 * @see app/Http/Controllers/Teacher/SectionController.php:22
 * @route '/docente/secciones'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Teacher\SectionController::index
 * @see app/Http/Controllers/Teacher/SectionController.php:22
 * @route '/docente/secciones'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Teacher\SectionController::index
 * @see app/Http/Controllers/Teacher/SectionController.php:22
 * @route '/docente/secciones'
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
* @see \App\Http\Controllers\Teacher\SectionController::show
 * @see app/Http/Controllers/Teacher/SectionController.php:46
 * @route '/docente/secciones/{section}'
 */
export const show = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/docente/secciones/{section}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Teacher\SectionController::show
 * @see app/Http/Controllers/Teacher/SectionController.php:46
 * @route '/docente/secciones/{section}'
 */
show.url = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return show.definition.url
            .replace('{section}', parsedArgs.section.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Teacher\SectionController::show
 * @see app/Http/Controllers/Teacher/SectionController.php:46
 * @route '/docente/secciones/{section}'
 */
show.get = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Teacher\SectionController::show
 * @see app/Http/Controllers/Teacher/SectionController.php:46
 * @route '/docente/secciones/{section}'
 */
show.head = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Teacher\SectionController::show
 * @see app/Http/Controllers/Teacher/SectionController.php:46
 * @route '/docente/secciones/{section}'
 */
    const showForm = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Teacher\SectionController::show
 * @see app/Http/Controllers/Teacher/SectionController.php:46
 * @route '/docente/secciones/{section}'
 */
        showForm.get = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Teacher\SectionController::show
 * @see app/Http/Controllers/Teacher/SectionController.php:46
 * @route '/docente/secciones/{section}'
 */
        showForm.head = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    show.form = showForm
/**
* @see \App\Http\Controllers\Teacher\SectionController::configure
 * @see app/Http/Controllers/Teacher/SectionController.php:106
 * @route '/docente/secciones/{section}/configurar'
 */
export const configure = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: configure.url(args, options),
    method: 'get',
})

configure.definition = {
    methods: ["get","head"],
    url: '/docente/secciones/{section}/configurar',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Teacher\SectionController::configure
 * @see app/Http/Controllers/Teacher/SectionController.php:106
 * @route '/docente/secciones/{section}/configurar'
 */
configure.url = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return configure.definition.url
            .replace('{section}', parsedArgs.section.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Teacher\SectionController::configure
 * @see app/Http/Controllers/Teacher/SectionController.php:106
 * @route '/docente/secciones/{section}/configurar'
 */
configure.get = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: configure.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Teacher\SectionController::configure
 * @see app/Http/Controllers/Teacher/SectionController.php:106
 * @route '/docente/secciones/{section}/configurar'
 */
configure.head = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: configure.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Teacher\SectionController::configure
 * @see app/Http/Controllers/Teacher/SectionController.php:106
 * @route '/docente/secciones/{section}/configurar'
 */
    const configureForm = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: configure.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Teacher\SectionController::configure
 * @see app/Http/Controllers/Teacher/SectionController.php:106
 * @route '/docente/secciones/{section}/configurar'
 */
        configureForm.get = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: configure.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Teacher\SectionController::configure
 * @see app/Http/Controllers/Teacher/SectionController.php:106
 * @route '/docente/secciones/{section}/configurar'
 */
        configureForm.head = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: configure.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    configure.form = configureForm
/**
* @see \App\Http\Controllers\Teacher\SectionController::setCompetencies
 * @see app/Http/Controllers/Teacher/SectionController.php:121
 * @route '/docente/secciones/{section}/configurar'
 */
export const setCompetencies = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: setCompetencies.url(args, options),
    method: 'post',
})

setCompetencies.definition = {
    methods: ["post"],
    url: '/docente/secciones/{section}/configurar',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Teacher\SectionController::setCompetencies
 * @see app/Http/Controllers/Teacher/SectionController.php:121
 * @route '/docente/secciones/{section}/configurar'
 */
setCompetencies.url = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return setCompetencies.definition.url
            .replace('{section}', parsedArgs.section.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Teacher\SectionController::setCompetencies
 * @see app/Http/Controllers/Teacher/SectionController.php:121
 * @route '/docente/secciones/{section}/configurar'
 */
setCompetencies.post = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: setCompetencies.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Teacher\SectionController::setCompetencies
 * @see app/Http/Controllers/Teacher/SectionController.php:121
 * @route '/docente/secciones/{section}/configurar'
 */
    const setCompetenciesForm = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: setCompetencies.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Teacher\SectionController::setCompetencies
 * @see app/Http/Controllers/Teacher/SectionController.php:121
 * @route '/docente/secciones/{section}/configurar'
 */
        setCompetenciesForm.post = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: setCompetencies.url(args, options),
            method: 'post',
        })
    
    setCompetencies.form = setCompetenciesForm
/**
* @see \App\Http\Controllers\Teacher\SectionController::close
 * @see app/Http/Controllers/Teacher/SectionController.php:81
 * @route '/docente/secciones/{section}/cerrar'
 */
export const close = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: close.url(args, options),
    method: 'patch',
})

close.definition = {
    methods: ["patch"],
    url: '/docente/secciones/{section}/cerrar',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\Teacher\SectionController::close
 * @see app/Http/Controllers/Teacher/SectionController.php:81
 * @route '/docente/secciones/{section}/cerrar'
 */
close.url = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return close.definition.url
            .replace('{section}', parsedArgs.section.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Teacher\SectionController::close
 * @see app/Http/Controllers/Teacher/SectionController.php:81
 * @route '/docente/secciones/{section}/cerrar'
 */
close.patch = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: close.url(args, options),
    method: 'patch',
})

    /**
* @see \App\Http\Controllers\Teacher\SectionController::close
 * @see app/Http/Controllers/Teacher/SectionController.php:81
 * @route '/docente/secciones/{section}/cerrar'
 */
    const closeForm = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: close.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PATCH',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Teacher\SectionController::close
 * @see app/Http/Controllers/Teacher/SectionController.php:81
 * @route '/docente/secciones/{section}/cerrar'
 */
        closeForm.patch = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: close.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PATCH',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    close.form = closeForm
/**
* @see \App\Http\Controllers\Teacher\SectionController::pdf
 * @see app/Http/Controllers/Teacher/SectionController.php:136
 * @route '/docente/secciones/{section}/pdf'
 */
export const pdf = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pdf.url(args, options),
    method: 'get',
})

pdf.definition = {
    methods: ["get","head"],
    url: '/docente/secciones/{section}/pdf',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Teacher\SectionController::pdf
 * @see app/Http/Controllers/Teacher/SectionController.php:136
 * @route '/docente/secciones/{section}/pdf'
 */
pdf.url = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return pdf.definition.url
            .replace('{section}', parsedArgs.section.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Teacher\SectionController::pdf
 * @see app/Http/Controllers/Teacher/SectionController.php:136
 * @route '/docente/secciones/{section}/pdf'
 */
pdf.get = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: pdf.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Teacher\SectionController::pdf
 * @see app/Http/Controllers/Teacher/SectionController.php:136
 * @route '/docente/secciones/{section}/pdf'
 */
pdf.head = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: pdf.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Teacher\SectionController::pdf
 * @see app/Http/Controllers/Teacher/SectionController.php:136
 * @route '/docente/secciones/{section}/pdf'
 */
    const pdfForm = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: pdf.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Teacher\SectionController::pdf
 * @see app/Http/Controllers/Teacher/SectionController.php:136
 * @route '/docente/secciones/{section}/pdf'
 */
        pdfForm.get = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: pdf.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Teacher\SectionController::pdf
 * @see app/Http/Controllers/Teacher/SectionController.php:136
 * @route '/docente/secciones/{section}/pdf'
 */
        pdfForm.head = (args: { section: number | { id: number } } | [section: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: pdf.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    pdf.form = pdfForm
const sections = {
    index: Object.assign(index, index),
show: Object.assign(show, show),
configure: Object.assign(configure, configure),
setCompetencies: Object.assign(setCompetencies, setCompetencies),
close: Object.assign(close, close),
pdf: Object.assign(pdf, pdf),
}

export default sections