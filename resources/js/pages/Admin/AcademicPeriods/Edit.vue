<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Save, ChevronLeft, AlertCircle } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
    academicPeriod: {
        id: number;
        name: string;
        start_date: string; // Vienen como string de fecha
        end_date: string;
        status: 'planning' | 'open' | 'closed';
    };
}>();

const form = useForm({
    _method: 'put', // Importante para la actualización en Laravel
    name: props.academicPeriod.name,
    start_date: props.academicPeriod.start_date,
    end_date: props.academicPeriod.end_date,
    status: props.academicPeriod.status,
});

const submit = () => {
    form.post(route('admin.academic_periods.update', props.academicPeriod.id), {
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
    <Head :title="`Editar Período: ${academicPeriod.name}`" />

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="max-w-3xl mx-auto">

            <!-- ENCABEZADO -->
            <div class="mb-10">
                <Link :href="route('admin.academic_periods.index')" class="text-blue-600 hover:text-blue-800 flex items-center mb-4">
                    <ChevronLeft class="w-4 h-4 mr-1" /> Volver a la lista
                </Link>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Editar Período Académico: <span class="text-blue-600">{{ academicPeriod.name }}</span></h1>
                <p class="mt-2 text-gray-600">Modifica la información del período seleccionado.</p>
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
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Período <span class="text-red-500">*</span></label>
                            <input type="text" id="name" v-model="form.name"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   :class="{ 'border-red-500': form.errors.name }"
                                   placeholder="Ej: 2025-I">
                            <div v-if="form.errors.name" class="text-sm text-red-600 mt-1">{{ form.errors.name }}</div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha de Inicio <span class="text-red-500">*</span></label>
                                <input type="date" id="start_date" v-model="form.start_date"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       :class="{ 'border-red-500': form.errors.start_date }">
                                <div v-if="form.errors.start_date" class="text-sm text-red-600 mt-1">{{ form.errors.start_date }}</div>
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Fecha de Fin <span class="text-red-500">*</span></label>
                                <input type="date" id="end_date" v-model="form.end_date"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                       :class="{ 'border-red-500': form.errors.end_date }">
                                <div v-if="form.errors.end_date" class="text-sm text-red-600 mt-1">{{ form.errors.end_date }}</div>
                            </div>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Estado <span class="text-red-500">*</span></label>
                            <select id="status" v-model="form.status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{ 'border-red-500': form.errors.status }">
                                <option value="planning">Planificado</option>
                                <option value="open">Abierto (Activo)</option>
                                <option value="closed">Cerrado</option>
                            </select>
                            <div v-if="form.errors.status" class="text-sm text-red-600 mt-1">{{ form.errors.status }}</div>
                            <p class="mt-1 text-xs text-gray-500">Solo un período puede estar "Abierto" a la vez. Al abrir uno, los demás se cerrarán.</p>
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
                            {{ form.processing ? 'Actualizando...' : 'Actualizar Período' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
