<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Plus, Edit, Trash2, CalendarCheck, CheckCircle2, AlertCircle } from 'lucide-vue-next';
import { ref } from 'vue';
import { route } from 'ziggy-js';


const props = defineProps<{
    academicPeriods: {
        data: any[];
        links: any[]; // Para paginación
        current_page: number;
        last_page: number;
        total: number;
    };

    flash: { success?: string; error?: string }; // Para mensajes flash
}>();

// Formulario para la acción de "Abrir" período
const openForm = useForm({});

const openAcademicPeriod = (periodId: number) => {
    if (confirm('¿Estás seguro de que quieres ABRIR este período? Esto CERRARÁ automáticamente cualquier otro período que esté actualmente abierto.')) {
        openForm.post(route('admin.academic_periods.open', periodId), {
            preserveScroll: true,
            onSuccess: () => {
                // Mensaje de éxito se mostrará vía flash
            },
            onError: (errors) => {
                console.error('Error al abrir período:', errors);
            }
        });
    }
};

// Formulario para eliminar
const deleteForm = useForm({});

const deleteAcademicPeriod = (periodId: number) => {
    if (confirm('¿Estás seguro de que quieres ELIMINAR este período? Esta acción no se puede deshacer.')) {
        deleteForm.delete(route('admin.academic_periods.destroy', periodId), {
            preserveScroll: true,
            onSuccess: () => {
                // Mensaje de éxito se mostrará vía flash
            },
            onError: (errors) => {
                console.error('Error al eliminar período:', errors);
                alert(props.flash.error || 'Hubo un error al intentar eliminar el período.');
            }
        });
    }
};
</script>

<template>
    <Head title="Períodos Académicos" />

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="max-w-7xl mx-auto">

            <!-- ENCABEZADO -->
            <div class="flex justify-between items-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Gestión de Períodos Académicos</h1>
                <Link :href="route('admin.academic_periods.create')"
                      class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <Plus class="w-5 h-5 mr-2" />
                    Nuevo Período
                </Link>
            </div>

            <!-- Mensajes Flash -->
            <div v-if="props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 flex items-center gap-3" role="alert">
                <CheckCircle2 class="w-5 h-5" />
                <span>{{ props.flash.success }}</span>
            </div>
            <div v-if="props.flash.error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 flex items-center gap-3" role="alert">
                <AlertCircle class="w-5 h-5" />
                <span>{{ props.flash.error }}</span>
            </div>


            <!-- TABLA DE PERÍODOS -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Inicio
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fin
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Acciones</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="period in academicPeriods.data" :key="period.id">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ period.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <!-- Formatear start_date -->
                                    {{ new Date(period.start_date).toLocaleDateString('es-ES', { year: 'numeric', month: '2-digit', day: '2-digit' }) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <!-- Formatear end_date -->
                                    {{ new Date(period.end_date).toLocaleDateString('es-ES', { year: 'numeric', month: '2-digit', day: '2-digit' }) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span :class="{
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800': period.status === 'planning',
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800': period.status === 'open',
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800': period.status === 'closed',
                                    }">
                                        {{ period.status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center space-x-2">
                                        <button v-if="period.status !== 'open'"
                                                @click="openAcademicPeriod(period.id)"
                                                :disabled="openForm.processing"
                                                class="text-blue-600 hover:text-blue-900 transition-colors p-1 rounded-md hover:bg-blue-50"
                                                title="Abrir Período">
                                            <CalendarCheck class="w-5 h-5" />
                                        </button>
                                        <Link :href="route('admin.academic_periods.edit', period.id)"
                                              class="text-indigo-600 hover:text-indigo-900 transition-colors p-1 rounded-md hover:bg-indigo-50"
                                              title="Editar">
                                            <Edit class="w-5 h-5" />
                                        </Link>
                                        <button @click="deleteAcademicPeriod(period.id)"
                                                :disabled="deleteForm.processing"
                                                class="text-red-600 hover:text-red-900 transition-colors p-1 rounded-md hover:bg-red-50"
                                                title="Eliminar">
                                            <Trash2 class="w-5 h-5" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="academicPeriods.data.length === 0">
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No hay períodos académicos registrados.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div v-if="academicPeriods.last_page > 1" class="flex justify-between items-center px-6 py-4 border-t border-gray-200">
                    <div class="text-sm text-gray-600">
                        Mostrando {{ academicPeriods.data.length }} de {{ academicPeriods.total }} períodos.
                    </div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <template v-for="(link, index) in academicPeriods.links" :key="index">
                            <!-- Si link.url es null, renderiza un span deshabilitado -->
                            <span v-if="link.url === null"
                                  :class="{
                                      'rounded-l-md': index === 0,
                                      'rounded-r-md': index === academicPeriods.links.length - 1,
                                  }"
                                  class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-gray-400 cursor-not-allowed text-sm font-medium opacity-50"
                                  v-html="link.label">
                            </span>
                            <!-- De lo contrario, renderiza el componente Link -->
                            <Link v-else
                                :href="link.url"
                                :class="{
                                    'bg-blue-600 text-white hover:bg-blue-700': link.active,
                                    'bg-white text-gray-700 hover:bg-gray-50': !link.active,
                                    'rounded-l-md': index === 0,
                                    'rounded-r-md': index === academicPeriods.links.length - 1,
                                }"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium"
                                v-html="link.label">
                            </Link>
                        </template>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>
