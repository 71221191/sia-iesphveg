import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\StudyProgramController::index
 * @see app/Http/Controllers/Admin/StudyProgramController.php:17
 * @route '/admin/programas'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/programas',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\StudyProgramController::index
 * @see app/Http/Controllers/Admin/StudyProgramController.php:17
 * @route '/admin/programas'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\StudyProgramController::index
 * @see app/Http/Controllers/Admin/StudyProgramController.php:17
 * @route '/admin/programas'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\StudyProgramController::index
 * @see app/Http/Controllers/Admin/StudyProgramController.php:17
 * @route '/admin/programas'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\StudyProgramController::index
 * @see app/Http/Controllers/Admin/StudyProgramController.php:17
 * @route '/admin/programas'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\StudyProgramController::index
 * @see app/Http/Controllers/Admin/StudyProgramController.php:17
 * @route '/admin/programas'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\StudyProgramController::index
 * @see app/Http/Controllers/Admin/StudyProgramController.php:17
 * @route '/admin/programas'
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
* @see \App\Http\Controllers\Admin\StudyProgramController::create
 * @see app/Http/Controllers/Admin/StudyProgramController.php:30
 * @route '/admin/programas/create'
 */
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/admin/programas/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\StudyProgramController::create
 * @see app/Http/Controllers/Admin/StudyProgramController.php:30
 * @route '/admin/programas/create'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\StudyProgramController::create
 * @see app/Http/Controllers/Admin/StudyProgramController.php:30
 * @route '/admin/programas/create'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\StudyProgramController::create
 * @see app/Http/Controllers/Admin/StudyProgramController.php:30
 * @route '/admin/programas/create'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\StudyProgramController::create
 * @see app/Http/Controllers/Admin/StudyProgramController.php:30
 * @route '/admin/programas/create'
 */
    const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: create.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\StudyProgramController::create
 * @see app/Http/Controllers/Admin/StudyProgramController.php:30
 * @route '/admin/programas/create'
 */
        createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: create.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\StudyProgramController::create
 * @see app/Http/Controllers/Admin/StudyProgramController.php:30
 * @route '/admin/programas/create'
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
* @see \App\Http\Controllers\Admin\StudyProgramController::store
 * @see app/Http/Controllers/Admin/StudyProgramController.php:39
 * @route '/admin/programas'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/programas',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\StudyProgramController::store
 * @see app/Http/Controllers/Admin/StudyProgramController.php:39
 * @route '/admin/programas'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\StudyProgramController::store
 * @see app/Http/Controllers/Admin/StudyProgramController.php:39
 * @route '/admin/programas'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\StudyProgramController::store
 * @see app/Http/Controllers/Admin/StudyProgramController.php:39
 * @route '/admin/programas'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\StudyProgramController::store
 * @see app/Http/Controllers/Admin/StudyProgramController.php:39
 * @route '/admin/programas'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\Admin\StudyProgramController::show
 * @see app/Http/Controllers/Admin/StudyProgramController.php:0
 * @route '/admin/programas/{studyProgram}'
 */
export const show = (args: { studyProgram: string | number } | [studyProgram: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/admin/programas/{studyProgram}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\StudyProgramController::show
 * @see app/Http/Controllers/Admin/StudyProgramController.php:0
 * @route '/admin/programas/{studyProgram}'
 */
show.url = (args: { studyProgram: string | number } | [studyProgram: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { studyProgram: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    studyProgram: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        studyProgram: args.studyProgram,
                }

    return show.definition.url
            .replace('{studyProgram}', parsedArgs.studyProgram.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\StudyProgramController::show
 * @see app/Http/Controllers/Admin/StudyProgramController.php:0
 * @route '/admin/programas/{studyProgram}'
 */
show.get = (args: { studyProgram: string | number } | [studyProgram: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\StudyProgramController::show
 * @see app/Http/Controllers/Admin/StudyProgramController.php:0
 * @route '/admin/programas/{studyProgram}'
 */
show.head = (args: { studyProgram: string | number } | [studyProgram: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\StudyProgramController::show
 * @see app/Http/Controllers/Admin/StudyProgramController.php:0
 * @route '/admin/programas/{studyProgram}'
 */
    const showForm = (args: { studyProgram: string | number } | [studyProgram: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\StudyProgramController::show
 * @see app/Http/Controllers/Admin/StudyProgramController.php:0
 * @route '/admin/programas/{studyProgram}'
 */
        showForm.get = (args: { studyProgram: string | number } | [studyProgram: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\StudyProgramController::show
 * @see app/Http/Controllers/Admin/StudyProgramController.php:0
 * @route '/admin/programas/{studyProgram}'
 */
        showForm.head = (args: { studyProgram: string | number } | [studyProgram: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Admin\StudyProgramController::edit
 * @see app/Http/Controllers/Admin/StudyProgramController.php:58
 * @route '/admin/programas/{studyProgram}/edit'
 */
export const edit = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/admin/programas/{studyProgram}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\StudyProgramController::edit
 * @see app/Http/Controllers/Admin/StudyProgramController.php:58
 * @route '/admin/programas/{studyProgram}/edit'
 */
edit.url = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { studyProgram: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { studyProgram: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    studyProgram: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        studyProgram: typeof args.studyProgram === 'object'
                ? args.studyProgram.id
                : args.studyProgram,
                }

    return edit.definition.url
            .replace('{studyProgram}', parsedArgs.studyProgram.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\StudyProgramController::edit
 * @see app/Http/Controllers/Admin/StudyProgramController.php:58
 * @route '/admin/programas/{studyProgram}/edit'
 */
edit.get = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\StudyProgramController::edit
 * @see app/Http/Controllers/Admin/StudyProgramController.php:58
 * @route '/admin/programas/{studyProgram}/edit'
 */
edit.head = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\StudyProgramController::edit
 * @see app/Http/Controllers/Admin/StudyProgramController.php:58
 * @route '/admin/programas/{studyProgram}/edit'
 */
    const editForm = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: edit.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\StudyProgramController::edit
 * @see app/Http/Controllers/Admin/StudyProgramController.php:58
 * @route '/admin/programas/{studyProgram}/edit'
 */
        editForm.get = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\StudyProgramController::edit
 * @see app/Http/Controllers/Admin/StudyProgramController.php:58
 * @route '/admin/programas/{studyProgram}/edit'
 */
        editForm.head = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Admin\StudyProgramController::update
 * @see app/Http/Controllers/Admin/StudyProgramController.php:69
 * @route '/admin/programas/{studyProgram}'
 */
export const update = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/admin/programas/{studyProgram}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Admin\StudyProgramController::update
 * @see app/Http/Controllers/Admin/StudyProgramController.php:69
 * @route '/admin/programas/{studyProgram}'
 */
update.url = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { studyProgram: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { studyProgram: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    studyProgram: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        studyProgram: typeof args.studyProgram === 'object'
                ? args.studyProgram.id
                : args.studyProgram,
                }

    return update.definition.url
            .replace('{studyProgram}', parsedArgs.studyProgram.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\StudyProgramController::update
 * @see app/Http/Controllers/Admin/StudyProgramController.php:69
 * @route '/admin/programas/{studyProgram}'
 */
update.put = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\Admin\StudyProgramController::update
 * @see app/Http/Controllers/Admin/StudyProgramController.php:69
 * @route '/admin/programas/{studyProgram}'
 */
update.patch = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

    /**
* @see \App\Http\Controllers\Admin\StudyProgramController::update
 * @see app/Http/Controllers/Admin/StudyProgramController.php:69
 * @route '/admin/programas/{studyProgram}'
 */
    const updateForm = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\StudyProgramController::update
 * @see app/Http/Controllers/Admin/StudyProgramController.php:69
 * @route '/admin/programas/{studyProgram}'
 */
        updateForm.put = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
            /**
* @see \App\Http\Controllers\Admin\StudyProgramController::update
 * @see app/Http/Controllers/Admin/StudyProgramController.php:69
 * @route '/admin/programas/{studyProgram}'
 */
        updateForm.patch = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\Admin\StudyProgramController::destroy
 * @see app/Http/Controllers/Admin/StudyProgramController.php:98
 * @route '/admin/programas/{studyProgram}'
 */
export const destroy = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/programas/{studyProgram}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Admin\StudyProgramController::destroy
 * @see app/Http/Controllers/Admin/StudyProgramController.php:98
 * @route '/admin/programas/{studyProgram}'
 */
destroy.url = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { studyProgram: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { studyProgram: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    studyProgram: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        studyProgram: typeof args.studyProgram === 'object'
                ? args.studyProgram.id
                : args.studyProgram,
                }

    return destroy.definition.url
            .replace('{studyProgram}', parsedArgs.studyProgram.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\StudyProgramController::destroy
 * @see app/Http/Controllers/Admin/StudyProgramController.php:98
 * @route '/admin/programas/{studyProgram}'
 */
destroy.delete = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\Admin\StudyProgramController::destroy
 * @see app/Http/Controllers/Admin/StudyProgramController.php:98
 * @route '/admin/programas/{studyProgram}'
 */
    const destroyForm = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\StudyProgramController::destroy
 * @see app/Http/Controllers/Admin/StudyProgramController.php:98
 * @route '/admin/programas/{studyProgram}'
 */
        destroyForm.delete = (args: { studyProgram: number | { id: number } } | [studyProgram: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy.form = destroyForm
const study_programs = {
    index: Object.assign(index, index),
create: Object.assign(create, create),
store: Object.assign(store, store),
show: Object.assign(show, show),
edit: Object.assign(edit, edit),
update: Object.assign(update, update),
destroy: Object.assign(destroy, destroy),
}

export default study_programs