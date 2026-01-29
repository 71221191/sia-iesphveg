import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\StudyPlanController::index
 * @see app/Http/Controllers/Admin/StudyPlanController.php:18
 * @route '/admin/planes'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/admin/planes',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\StudyPlanController::index
 * @see app/Http/Controllers/Admin/StudyPlanController.php:18
 * @route '/admin/planes'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\StudyPlanController::index
 * @see app/Http/Controllers/Admin/StudyPlanController.php:18
 * @route '/admin/planes'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\StudyPlanController::index
 * @see app/Http/Controllers/Admin/StudyPlanController.php:18
 * @route '/admin/planes'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\StudyPlanController::index
 * @see app/Http/Controllers/Admin/StudyPlanController.php:18
 * @route '/admin/planes'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\StudyPlanController::index
 * @see app/Http/Controllers/Admin/StudyPlanController.php:18
 * @route '/admin/planes'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\StudyPlanController::index
 * @see app/Http/Controllers/Admin/StudyPlanController.php:18
 * @route '/admin/planes'
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
* @see \App\Http\Controllers\Admin\StudyPlanController::create
 * @see app/Http/Controllers/Admin/StudyPlanController.php:35
 * @route '/admin/planes/create'
 */
export const create = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})

create.definition = {
    methods: ["get","head"],
    url: '/admin/planes/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\StudyPlanController::create
 * @see app/Http/Controllers/Admin/StudyPlanController.php:35
 * @route '/admin/planes/create'
 */
create.url = (options?: RouteQueryOptions) => {
    return create.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\StudyPlanController::create
 * @see app/Http/Controllers/Admin/StudyPlanController.php:35
 * @route '/admin/planes/create'
 */
create.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: create.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\StudyPlanController::create
 * @see app/Http/Controllers/Admin/StudyPlanController.php:35
 * @route '/admin/planes/create'
 */
create.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: create.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\StudyPlanController::create
 * @see app/Http/Controllers/Admin/StudyPlanController.php:35
 * @route '/admin/planes/create'
 */
    const createForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: create.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\StudyPlanController::create
 * @see app/Http/Controllers/Admin/StudyPlanController.php:35
 * @route '/admin/planes/create'
 */
        createForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: create.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\StudyPlanController::create
 * @see app/Http/Controllers/Admin/StudyPlanController.php:35
 * @route '/admin/planes/create'
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
* @see \App\Http\Controllers\Admin\StudyPlanController::store
 * @see app/Http/Controllers/Admin/StudyPlanController.php:48
 * @route '/admin/planes'
 */
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/admin/planes',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Admin\StudyPlanController::store
 * @see app/Http/Controllers/Admin/StudyPlanController.php:48
 * @route '/admin/planes'
 */
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\StudyPlanController::store
 * @see app/Http/Controllers/Admin/StudyPlanController.php:48
 * @route '/admin/planes'
 */
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Admin\StudyPlanController::store
 * @see app/Http/Controllers/Admin/StudyPlanController.php:48
 * @route '/admin/planes'
 */
    const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: store.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\StudyPlanController::store
 * @see app/Http/Controllers/Admin/StudyPlanController.php:48
 * @route '/admin/planes'
 */
        storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: store.url(options),
            method: 'post',
        })
    
    store.form = storeForm
/**
* @see \App\Http\Controllers\Admin\StudyPlanController::show
 * @see app/Http/Controllers/Admin/StudyPlanController.php:0
 * @route '/admin/planes/{studyPlan}'
 */
export const show = (args: { studyPlan: string | number } | [studyPlan: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/admin/planes/{studyPlan}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\StudyPlanController::show
 * @see app/Http/Controllers/Admin/StudyPlanController.php:0
 * @route '/admin/planes/{studyPlan}'
 */
show.url = (args: { studyPlan: string | number } | [studyPlan: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { studyPlan: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    studyPlan: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        studyPlan: args.studyPlan,
                }

    return show.definition.url
            .replace('{studyPlan}', parsedArgs.studyPlan.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\StudyPlanController::show
 * @see app/Http/Controllers/Admin/StudyPlanController.php:0
 * @route '/admin/planes/{studyPlan}'
 */
show.get = (args: { studyPlan: string | number } | [studyPlan: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\StudyPlanController::show
 * @see app/Http/Controllers/Admin/StudyPlanController.php:0
 * @route '/admin/planes/{studyPlan}'
 */
show.head = (args: { studyPlan: string | number } | [studyPlan: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\StudyPlanController::show
 * @see app/Http/Controllers/Admin/StudyPlanController.php:0
 * @route '/admin/planes/{studyPlan}'
 */
    const showForm = (args: { studyPlan: string | number } | [studyPlan: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\StudyPlanController::show
 * @see app/Http/Controllers/Admin/StudyPlanController.php:0
 * @route '/admin/planes/{studyPlan}'
 */
        showForm.get = (args: { studyPlan: string | number } | [studyPlan: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\StudyPlanController::show
 * @see app/Http/Controllers/Admin/StudyPlanController.php:0
 * @route '/admin/planes/{studyPlan}'
 */
        showForm.head = (args: { studyPlan: string | number } | [studyPlan: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Admin\StudyPlanController::edit
 * @see app/Http/Controllers/Admin/StudyPlanController.php:79
 * @route '/admin/planes/{studyPlan}/edit'
 */
export const edit = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})

edit.definition = {
    methods: ["get","head"],
    url: '/admin/planes/{studyPlan}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\StudyPlanController::edit
 * @see app/Http/Controllers/Admin/StudyPlanController.php:79
 * @route '/admin/planes/{studyPlan}/edit'
 */
edit.url = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { studyPlan: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { studyPlan: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    studyPlan: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        studyPlan: typeof args.studyPlan === 'object'
                ? args.studyPlan.id
                : args.studyPlan,
                }

    return edit.definition.url
            .replace('{studyPlan}', parsedArgs.studyPlan.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\StudyPlanController::edit
 * @see app/Http/Controllers/Admin/StudyPlanController.php:79
 * @route '/admin/planes/{studyPlan}/edit'
 */
edit.get = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: edit.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\StudyPlanController::edit
 * @see app/Http/Controllers/Admin/StudyPlanController.php:79
 * @route '/admin/planes/{studyPlan}/edit'
 */
edit.head = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: edit.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\StudyPlanController::edit
 * @see app/Http/Controllers/Admin/StudyPlanController.php:79
 * @route '/admin/planes/{studyPlan}/edit'
 */
    const editForm = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: edit.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\StudyPlanController::edit
 * @see app/Http/Controllers/Admin/StudyPlanController.php:79
 * @route '/admin/planes/{studyPlan}/edit'
 */
        editForm.get = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: edit.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\StudyPlanController::edit
 * @see app/Http/Controllers/Admin/StudyPlanController.php:79
 * @route '/admin/planes/{studyPlan}/edit'
 */
        editForm.head = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
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
* @see \App\Http\Controllers\Admin\StudyPlanController::update
 * @see app/Http/Controllers/Admin/StudyPlanController.php:93
 * @route '/admin/planes/{studyPlan}'
 */
export const update = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/admin/planes/{studyPlan}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Admin\StudyPlanController::update
 * @see app/Http/Controllers/Admin/StudyPlanController.php:93
 * @route '/admin/planes/{studyPlan}'
 */
update.url = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { studyPlan: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { studyPlan: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    studyPlan: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        studyPlan: typeof args.studyPlan === 'object'
                ? args.studyPlan.id
                : args.studyPlan,
                }

    return update.definition.url
            .replace('{studyPlan}', parsedArgs.studyPlan.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\StudyPlanController::update
 * @see app/Http/Controllers/Admin/StudyPlanController.php:93
 * @route '/admin/planes/{studyPlan}'
 */
update.put = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})
/**
* @see \App\Http\Controllers\Admin\StudyPlanController::update
 * @see app/Http/Controllers/Admin/StudyPlanController.php:93
 * @route '/admin/planes/{studyPlan}'
 */
update.patch = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

    /**
* @see \App\Http\Controllers\Admin\StudyPlanController::update
 * @see app/Http/Controllers/Admin/StudyPlanController.php:93
 * @route '/admin/planes/{studyPlan}'
 */
    const updateForm = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: update.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'PUT',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\StudyPlanController::update
 * @see app/Http/Controllers/Admin/StudyPlanController.php:93
 * @route '/admin/planes/{studyPlan}'
 */
        updateForm.put = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: update.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'PUT',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
            /**
* @see \App\Http\Controllers\Admin\StudyPlanController::update
 * @see app/Http/Controllers/Admin/StudyPlanController.php:93
 * @route '/admin/planes/{studyPlan}'
 */
        updateForm.patch = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
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
* @see \App\Http\Controllers\Admin\StudyPlanController::destroy
 * @see app/Http/Controllers/Admin/StudyPlanController.php:123
 * @route '/admin/planes/{studyPlan}'
 */
export const destroy = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/admin/planes/{studyPlan}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Admin\StudyPlanController::destroy
 * @see app/Http/Controllers/Admin/StudyPlanController.php:123
 * @route '/admin/planes/{studyPlan}'
 */
destroy.url = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { studyPlan: args }
    }

            if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
            args = { studyPlan: args.id }
        }
    
    if (Array.isArray(args)) {
        args = {
                    studyPlan: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        studyPlan: typeof args.studyPlan === 'object'
                ? args.studyPlan.id
                : args.studyPlan,
                }

    return destroy.definition.url
            .replace('{studyPlan}', parsedArgs.studyPlan.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\StudyPlanController::destroy
 * @see app/Http/Controllers/Admin/StudyPlanController.php:123
 * @route '/admin/planes/{studyPlan}'
 */
destroy.delete = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

    /**
* @see \App\Http\Controllers\Admin\StudyPlanController::destroy
 * @see app/Http/Controllers/Admin/StudyPlanController.php:123
 * @route '/admin/planes/{studyPlan}'
 */
    const destroyForm = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: destroy.url(args, {
                    [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                        _method: 'DELETE',
                        ...(options?.query ?? options?.mergeQuery ?? {}),
                    }
                }),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Admin\StudyPlanController::destroy
 * @see app/Http/Controllers/Admin/StudyPlanController.php:123
 * @route '/admin/planes/{studyPlan}'
 */
        destroyForm.delete = (args: { studyPlan: number | { id: number } } | [studyPlan: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: destroy.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'DELETE',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'post',
        })
    
    destroy.form = destroyForm
const study_plans = {
    index: Object.assign(index, index),
create: Object.assign(create, create),
store: Object.assign(store, store),
show: Object.assign(show, show),
edit: Object.assign(edit, edit),
update: Object.assign(update, update),
destroy: Object.assign(destroy, destroy),
}

export default study_plans