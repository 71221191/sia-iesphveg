<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Save, ChevronLeft, AlertCircle } from 'lucide-vue-next';
import { computed } from 'vue';
import { route } from 'ziggy-js';

const props = defineProps<{
    studyPlan: {
        id: number;
        study_program_id: number;
        name: string;
        resolution_code: string | null;
        evaluation_type: 'vigesimal' | 'competency';
        is_active: boolean;
        valid_from_year: number;
        valid_to_year: number | null;
    };
    studyPrograms: any[]; // Lista de StudyPrograms para el select
}>();

const form = useForm({
    _method: 'put', // Importante para la actualización en Laravel
    study_program_id: props.studyPlan.study_program_id,
    name: props.studyPlan.name,
    resolution_code: props.studyPlan.resolution_code,
    evaluation_type: props.studyPlan.evaluation_type,
    is_active: props.studyPlan.is_active,
    valid_from_year: props.studyPlan.valid_from_year,
    valid_to_year: props.studyPlan.valid_to_year,
});

const currentYear = new Date().getFullYear();
const years = computed(() => {
    const arr = [];
    for (let i = currentYear - 20; i <= currentYear + 5; i++) {
        arr.push(i);
    }
    return arr;
});

const submit = () => {
    form.post(route('admin.study_plans.update', props.studyPlan.id), {
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
    <Head :title="`Editar Plan: ${studyPlan.name}`" />

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="max-w-3xl mx-auto">

            <!-- ENCABEZADO -->
            <div class="mb-10">
                <Link :href="route('admin.study_plans.index')" class="text-blue-600 hover:text-blue-800 flex items-center mb-4">
                    <ChevronLeft class="w-4 h-4 mr-1" /> Volver a la lista
                </Link>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Editar Plan de Estudio: <span class="text-blue-600">{{ studyPlan.name }}</span></h1>
                <p class="mt-2 text-gray-600">Modifica las características del plan seleccionado.</p>
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
                            <label for="study_program_id" class="block text-sm font-medium text-gray-700">Carrera Asociada <span class="text-red-500">*</span></label>
                            <select id="study_program_id" v-model="form.study_program_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{ 'border-red-500': form.errors.study_program_id }">
                                <option :value="null" disabled>Seleccione una carrera...</option>
                                <option v-for="program in studyPrograms" :key="program.id" :value="program.id">
                                    {{ program.name }} ({{ program.short_name }})
                                </option>
                            </select>
                            <div v-if="form.errors.study_program_id" class="text-sm text-red-600 mt-1">{{ form.errors.study_program_id }}</div>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Plan <span class="text-red-500">*</span></label>
                            <input type="text" id="name" v-model="form.name"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   :class="{ 'border-red-500': form.errors.name }"
                                   placeholder="Ej: 2019 (DCBN)">
                            <div v-if="form.errors.name" class="text-sm text-red-600 mt-1">{{ form.errors.name }}</div>
                            <p class="mt-1 text-xs text-gray-500">Identificador del plan (Ej: Año de aprobación, alias).</p>
                        </div>

                        <div>
                            <label for="resolution_code" class="block text-sm font-medium text-gray-700">Código de Resolución (Opcional)</label>
                            <input type="text" id="resolution_code" v-model="form.resolution_code"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   :class="{ 'border-red-500': form.errors.resolution_code }"
                                   placeholder="Ej: RVM Nº 163-2019-MINEDU">
                            <div v-if="form.errors.resolution_code" class="text-sm text-red-600 mt-1">{{ form.errors.resolution_code }}</div>
                        </div>

                        <div>
                            <label for="evaluation_type" class="block text-sm font-medium text-gray-700">Tipo de Evaluación <span class="text-red-500">*</span></label>
                            <select id="evaluation_type" v-model="form.evaluation_type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{ 'border-red-500': form.errors.evaluation_type }">
                                <option value="vigesimal">Vigesimal (0-20)</option>
                                <option value="competency">Por Competencias</option>
                            </select>
                            <div v-if="form.errors.evaluation_type" class="text-sm text-red-600 mt-1">{{ form.errors.evaluation_type }}</div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="valid_from_year" class="block text-sm font-medium text-gray-700">Válido Desde el Año <span class="text-red-500">*</span></label>
                                <select id="valid_from_year" v-model="form.valid_from_year"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        :class="{ 'border-red-500': form.errors.valid_from_year }">
                                    <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                                </select>
                                <div v-if="form.errors.valid_from_year" class="text-sm text-red-600 mt-1">{{ form.errors.valid_from_year }}</div>
                            </div>
                            <div>
                                <label for="valid_to_year" class="block text-sm font-medium text-gray-700">Válido Hasta el Año (Opcional)</label>
                                <select id="valid_to_year" v-model="form.valid_to_year"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        :class="{ 'border-red-500': form.errors.valid_to_year }">
                                    <option :value="null">Sin límite</option>
                                    <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                                </select>
                                <div v-if="form.errors.valid_to_year" class="text-sm text-red-600 mt-1">{{ form.errors.valid_to_year }}</div>
                            </div>
                        </div>

                        <div>
                            <label for="is_active" class="block text-sm font-medium text-gray-700">Estado</label>
                            <select id="is_active" v-model="form.is_active"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{ 'border-red-500': form.errors.is_active }">
                                <option :value="true">Activo</option>
                                <option :value="false">Inactivo</option>
                            </select>
                            <div v-if="form.errors.is_active" class="text-sm text-red-600 mt-1">{{ form.errors.is_active }}</div>
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
                            {{ form.processing ? 'Actualizando...' : 'Actualizar Plan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
