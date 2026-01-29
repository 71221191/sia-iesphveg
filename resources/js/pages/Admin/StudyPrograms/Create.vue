<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Save, ChevronLeft, AlertCircle } from 'lucide-vue-next';
import { route } from 'ziggy-js';

const form = useForm({
    name: '',
    code: '',
    short_name: '',
});

const submit = () => {
    form.post(route('admin.study_programs.store'), {
        onSuccess: () => {
            // Se maneja con flash messages en Index
        },
        onError: (errors) => {
            console.error('Errores de validación:', errors);
        }
    });
};
</script>

<template>
    <Head title="Crear Carrera" />

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="max-w-3xl mx-auto">

            <!-- ENCABEZADO -->
            <div class="mb-10">
                <Link :href="route('admin.study_programs.index')" class="text-blue-600 hover:text-blue-800 flex items-center mb-4">
                    <ChevronLeft class="w-4 h-4 mr-1" /> Volver a la lista
                </Link>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Crear Nueva Carrera</h1>
                <p class="mt-2 text-gray-600">Define los detalles de la nueva carrera.</p>
            </div>

            <!-- BLOQUE GENERAL DE ERRORES -->
            <div v-if="Object.keys(form.errors).length > 0" class="bg-red-50 border border-red-300 text-red-800 px-6 py-4 rounded-lg mb-8 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <AlertCircle class="w-5 h-5 shrink-0" />
                    <h3 class="font-bold text-lg">Por favor, corrige los siguientes errores:</h3>
                </div>
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    <li v-for="(error, field) in form.errors" :key="field">
                        {{ error }}
                    </li>
                </ul>
            </div>
            <!-- FIN BLOQUE GENERAL DE ERRORES -->

            <!-- FORMULARIO CARD -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden p-6 sm:p-10">
                <form @submit.prevent="submit">
                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo de la Carrera <span class="text-red-500">*</span></label>
                            <input type="text" id="name" v-model="form.name"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   :class="{ 'border-red-500': form.errors.name }"
                                   placeholder="Ej: Computación e Informática">
                            <div v-if="form.errors.name" class="text-sm text-red-600 mt-1">{{ form.errors.name }}</div>
                        </div>

                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700">Código Modular (Opcional)</label>
                            <input type="text" id="code" v-model="form.code"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   :class="{ 'border-red-500': form.errors.code }"
                                   placeholder="Ej: 001-2025">
                            <div v-if="form.errors.code" class="text-sm text-red-600 mt-1">{{ form.errors.code }}</div>
                        </div>

                        <div>
                            <label for="short_name" class="block text-sm font-medium text-gray-700">Nombre Corto (Opcional)</label>
                            <input type="text" id="short_name" v-model="form.short_name"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   :class="{ 'border-red-500': form.errors.short_name }"
                                   placeholder="Ej: Cómputo">
                            <div v-if="form.errors.short_name" class="text-sm text-red-600 mt-1">{{ form.errors.short_name }}</div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                        <button type="submit"
                                :disabled="form.processing"
                                :class="{
                                    'bg-green-600 hover:bg-green-700 text-white': !form.processing,
                                    'bg-gray-300 text-gray-500 cursor-not-allowed': form.processing
                                }"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <Save class="w-5 h-5 mr-2" />
                            {{ form.processing ? 'Guardando...' : 'Guardar Carrera' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
