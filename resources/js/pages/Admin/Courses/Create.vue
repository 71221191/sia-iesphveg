<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Save, ChevronLeft, AlertCircle } from 'lucide-vue-next';
import { route } from 'ziggy-js';

const props = defineProps<{
    studyPlans: any[]; // Lista de StudyPlans para el select
    cycles: string[]; // Lista de ciclos (ej: I, II, III)
    courseTypes: string[]; // Lista de tipos de curso (ej: general, specific, elective)
}>();

const form = useForm({
    study_plan_id: null,
    name: '',
    code: '',
    cycle: 'I', // Valor por defecto
    credits: 0.0,
    hours_theory: 0,
    hours_practice: 0,
    type: 'general', // Valor por defecto
    is_legacy: false, // Por defecto no es legacy
});

const submit = () => {
    form.post(route('admin.courses.store'), {
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
    <Head title="Crear Curso" />

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="max-w-3xl mx-auto">

            <!-- ENCABEZADO -->
            <div class="mb-10">
                <Link :href="route('admin.courses.index')" class="text-blue-600 hover:text-blue-800 flex items-center mb-4">
                    <ChevronLeft class="w-4 h-4 mr-1" /> Volver a la lista
                </Link>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Crear Nuevo Curso</h1>
                <p class="mt-2 text-gray-600">Define los detalles del nuevo curso y su asociación a un plan.</p>
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
                            <label for="study_plan_id" class="block text-sm font-medium text-gray-700">Plan de Estudio Asociado <span class="text-red-500">*</span></label>
                            <select id="study_plan_id" v-model="form.study_plan_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{ 'border-red-500': form.errors.study_plan_id }">
                                <option :value="null" disabled>Seleccione un plan de estudio...</option>
                                <option v-for="plan in studyPlans" :key="plan.id" :value="plan.id">
                                    {{ plan.name }}
                                </option>
                            </select>
                            <div v-if="form.errors.study_plan_id" class="text-sm text-red-600 mt-1">{{ form.errors.study_plan_id }}</div>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Curso <span class="text-red-500">*</span></label>
                            <input type="text" id="name" v-model="form.name"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   :class="{ 'border-red-500': form.errors.name }"
                                   placeholder="Ej: Álgebra Lineal">
                            <div v-if="form.errors.name" class="text-sm text-red-600 mt-1">{{ form.errors.name }}</div>
                        </div>

                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700">Código del Curso <span class="text-red-500">*</span></label>
                            <input type="text" id="code" v-model="form.code"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   :class="{ 'border-red-500': form.errors.code }"
                                   placeholder="Ej: MAT101">
                            <div v-if="form.errors.code" class="text-sm text-red-600 mt-1">{{ form.errors.code }}</div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="cycle" class="block text-sm font-medium text-gray-700">Ciclo <span class="text-red-500">*</span></label>
                                <select id="cycle" v-model="form.cycle"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        :class="{ 'border-red-500': form.errors.cycle }">
                                    <option v-for="cycle in cycles" :key="cycle" :value="cycle">{{ cycle }}</option>
                                </select>
                                <div v-if="form.errors.cycle" class="text-sm text-red-600 mt-1">{{ form.errors.cycle }}</div>
                            </div>
                            <div>
                                <label for="credits" class="block text-sm font-medium text-gray-700">Créditos <span class="text-red-500">*</span></label>
                                <input type="number" id="credits" v-model="form.credits" step="0.5" min="0.5" max="20"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       :class="{ 'border-red-500': form.errors.credits }">
                                <div v-if="form.errors.credits" class="text-sm text-red-600 mt-1">{{ form.errors.credits }}</div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="hours_theory" class="block text-sm font-medium text-gray-700">Horas de Teoría</label>
                                <input type="number" id="hours_theory" v-model="form.hours_theory" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       :class="{ 'border-red-500': form.errors.hours_theory }">
                                <div v-if="form.errors.hours_theory" class="text-sm text-red-600 mt-1">{{ form.errors.hours_theory }}</div>
                            </div>
                            <div>
                                <label for="hours_practice" class="block text-sm font-medium text-gray-700">Horas de Práctica</label>
                                <input type="number" id="hours_practice" v-model="form.hours_practice" min="0"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       :class="{ 'border-red-500': form.errors.hours_practice }">
                                <div v-if="form.errors.hours_practice" class="text-sm text-red-600 mt-1">{{ form.errors.hours_practice }}</div>
                            </div>
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Curso <span class="text-red-500">*</span></label>
                            <select id="type" v-model="form.type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{ 'border-red-500': form.errors.type }">
                                <option v-for="type in courseTypes" :key="type" :value="type" class="capitalize">{{ type }}</option>
                            </select>
                            <div v-if="form.errors.type" class="text-sm text-red-600 mt-1">{{ form.errors.type }}</div>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="is_legacy" v-model="form.is_legacy"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <label for="is_legacy" class="ml-2 block text-sm text-gray-700">Curso Heredado (Legacy)</label>
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
                            {{ form.processing ? 'Guardando...' : 'Guardar Curso' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
