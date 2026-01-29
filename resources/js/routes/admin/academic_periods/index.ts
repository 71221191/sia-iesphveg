import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::index
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:19
 * @route '/admin/periodos'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/periodos',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::index
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:19
 * @route '/admin/periodos'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::index
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:19
 * @route '/admin/periodos'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::index
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:19
 * @route '/admin/periodos'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::index
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:19
 * @route '/admin/periodos'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::index
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:19
 * @route '/admin/periodos'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::index
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:19
 * @route '/admin/periodos'
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
* @see \App\Http\Controllers\Admin\AcademicPeriodController::create
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:36
 * @route '/admin/periodos/create'
 */
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/admin/periodos/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::create
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:36
 * @route '/admin/periodos/create'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::create
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:36
 * @route '/admin/periodos/create'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::create
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:36
 * @route '/admin/periodos/create'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::create
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:36
 * @route '/admin/periodos/create'
 */
    const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: create.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::create
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:36
 * @route '/admin/periodos/create'
 */
        createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: create.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::create
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:36
 * @route '/admin/periodos/create'
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
* @see \App\Http\Controllers\Admin\AcademicPeriodController::store
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:45
 * @route '/admin/periodos'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/periodos',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::store
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:45
 * @route '/admin/periodos'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::store
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:45
 * @route '/admin/periodos'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::store
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:45
 * @route '/admin/periodos'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::store
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:45
 * @route '/admin/periodos'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::show
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:0
 * @route '/admin/periodos/{academicPeriod}'
 */
export const show = (args: { academicPeriod: string | number } | [academicPeriod: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/admin/periodos/{academicPeriod}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::show
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:0
 * @route '/admin/periodos/{academicPeriod}'
 */
show.url = (args: { academicPeriod: string | number } | [academicPeriod: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { academicPeriod: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    academicPeriod: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        academicPeriod: args.academicPeriod,
                }

    return show.definition.url
            .replace('{academicPeriod}', parsedArgs.academicPeriod.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::show
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:0
 * @route '/admin/periodos/{academicPeriod}'
 */
show.get = (args: { academicPeriod: string | number } | [academicPeriod: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::show
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:0
 * @route '/admin/periodos/{academicPeriod}'
 */
show.head = (args: { academicPeriod: string | number } | [academicPeriod: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::show
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:0
 * @route '/admin/periodos/{academicPeriod}'
 */
    const showForm = (args: { academicPeriod: string | number } | [academicPeriod: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::show
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:0
 * @route '/admin/periodos/{academicPeriod}'
 */
        showForm.get = (args: { academicPeriod: string | number } | [academicPeriod: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::show
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:0
 * @route '/admin/periodos/{academicPeriod}'
 */
        showForm.head = (args: { academicPeriod: string | number } | [academicPeriod: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Admin\AcademicPeriodController::edit
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:65
 * @route '/admin/periodos/{academicPeriod}/edit'
 */
export const edit = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/admin/periodos/{academicPeriod}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::edit
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:65
 * @route '/admin/periodos/{academicPeriod}/edit'
 */
edit.url = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { academicPeriod: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { academicPeriod: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    academicPeriod: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        academicPeriod: typeof args.academicPeriod === 'object'
                ? args.academicPeriod.id
                : args.academicPeriod,
                }

    return edit.definition.url
            .replace('{academicPeriod}', parsedArgs.academicPeriod.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::edit
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:65
 * @route '/admin/periodos/{academicPeriod}/edit'
 */
edit.get = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::edit
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:65
 * @route '/admin/periodos/{academicPeriod}/edit'
 */
edit.head = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::edit
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:65
 * @route '/admin/periodos/{academicPeriod}/edit'
 */
    const editForm = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: edit.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::edit
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:65
 * @route '/admin/periodos/{academicPeriod}/edit'
 */
        editForm.get = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::edit
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:65
 * @route '/admin/periodos/{academicPeriod}/edit'
 */
        editForm.head = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    edit.form = editForm
/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::update
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:76
 * @route '/admin/periodos/{academicPeriod}'
 */
export const update = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/admin/periodos/{academicPeriod}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::update
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:76
 * @route '/admin/periodos/{academicPeriod}'
 */
update.url = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { academicPeriod: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { academicPeriod: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    academicPeriod: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        academicPeriod: typeof args.academicPeriod === 'object'
                ? args.academicPeriod.id
                : args.academicPeriod,
                }

    return update.definition.url
            .replace('{academicPeriod}', parsedArgs.academicPeriod.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::update
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:76
 * @route '/admin/periodos/{academicPeriod}'
 */
update.put = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::update
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:76
 * @route '/admin/periodos/{academicPeriod}'
 */
update.patch = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

    /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::update
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:76
 * @route '/admin/periodos/{academicPeriod}'
 */
    const updateForm = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::update
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:76
 * @route '/admin/periodos/{academicPeriod}'
 */
        updateForm.put = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
            /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::update
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:76
 * @route '/admin/periodos/{academicPeriod}'
 */
        updateForm.patch = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PATCH',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    update.form = updateForm
/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::destroy
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:101
 * @route '/admin/periodos/{academicPeriod}'
 */
export const destroy = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/periodos/{academicPeriod}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::destroy
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:101
 * @route '/admin/periodos/{academicPeriod}'
 */
destroy.url = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { academicPeriod: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { academicPeriod: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    academicPeriod: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        academicPeriod: typeof args.academicPeriod === 'object'
                ? args.academicPeriod.id
                : args.academicPeriod,
                }

    return destroy.definition.url
            .replace('{academicPeriod}', parsedArgs.academicPeriod.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::destroy
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:101
 * @route '/admin/periodos/{academicPeriod}'
 */
destroy.delete = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::destroy
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:101
 * @route '/admin/periodos/{academicPeriod}'
 */
    const destroyForm = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::destroy
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:101
 * @route '/admin/periodos/{academicPeriod}'
 */
        destroyForm.delete = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy.form = destroyForm
/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::open
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:117
 * @route '/admin/periodos/{academicPeriod}/open'
 */
export const open = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: open.url(args, options),
    method: 'post',
})

open.definition = {
    methods: ["post"],
    url: '/admin/periodos/{academicPeriod}/open',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::open
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:117
 * @route '/admin/periodos/{academicPeriod}/open'
 */
open.url = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { academicPeriod: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { academicPeriod: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    academicPeriod: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        academicPeriod: typeof args.academicPeriod === 'object'
                ? args.academicPeriod.id
                : args.academicPeriod,
                }

    return open.definition.url
            .replace('{academicPeriod}', parsedArgs.academicPeriod.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::open
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:117
 * @route '/admin/periodos/{academicPeriod}/open'
 */
open.post = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: open.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::open
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:117
 * @route '/admin/periodos/{academicPeriod}/open'
 */
    const openForm = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: open.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\AcademicPeriodController::open
 * @see app/Http/Controllers/Admin/AcademicPeriodController.php:117
 * @route '/admin/periodos/{academicPeriod}/open'
 */
        openForm.post = (args: { academicPeriod: number | { id: number } } | [academicPeriod: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: open.url(args, options),
            method: 'post',
        })
    
    open.form = openForm
const academic_periods = {
    index: Object.assign(index, index),
create: Object.assign(create, create),
store: Object.assign(store, store),
show: Object.assign(show, show),
edit: Object.assign(edit, edit),
update: Object.assign(update, update),
destroy: Object.assign(destroy, destroy),
open: Object.assign(open, open),
}

export default academic_periods