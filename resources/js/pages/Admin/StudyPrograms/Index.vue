<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Plus, Edit, Trash2, CheckCircle2, AlertCircle } from 'lucide-vue-next';
import { route } from 'ziggy-js';

const props = defineProps<{
    studyPrograms: {
        data: any[];
        links: any[]; // Para paginación
        current_page: number;
        last_page: number;
        total: number; // Para mostrar el total de registros
    };
}>();

// Formulario para eliminar
const deleteForm = useForm({});

const deleteStudyProgram = (programId: number, programName: string) => {
    if (confirm(`¿Estás seguro de que quieres ELIMINAR el programa de estudio "${programName}"? Esta acción no se puede deshacer y puede afectar a planes de estudio asociados.`)) {
        deleteForm.delete(route('admin.study_programs.destroy', programId), {
            preserveScroll: true,
            onSuccess: () => {
                // Mensaje de éxito se mostrará vía flash
            },
            onError: (errors) => {
                console.error('Error al eliminar programa de estudio:', errors);
                alert(props.flash.error || 'Hubo un error al intentar eliminar el programa de estudio.');
            }
        });
    }
};
</script>

<template>
    <Head title="Programas de Estudio" />

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="max-w-7xl mx-auto">

            <!-- ENCABEZADO -->
            <div class="flex justify-between items-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Gestión de Programas de Estudio (Carreras)</h1>
                <Link :href="route('admin.study_programs.create')"
                      class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <Plus class="w-5 h-5 mr-2" />
                    Nueva Carrera
                </Link>
            </div>

            <!-- Mensajes Flash -->
            <div v-if="$page.props.flash.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 flex items-center gap-3" role="alert">
                <CheckCircle2 class="w-5 h-5" />
                <span>{{ $page.props.flash.success }}</span>
            </div>
            <div v-if="$page.props.flash.error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 flex items-center gap-3" role="alert">
                <AlertCircle class="w-5 h-5" />
                <span>{{ $page.props.flash.error }}</span>
            </div>


            <!-- TABLA DE PROGRAMAS DE ESTUDIO -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre de Carrera
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Código Modular
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre Corto
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Acciones</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="program in studyPrograms.data" :key="program.id">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ program.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ program.code || 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ program.short_name || 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center space-x-2">
                                        <Link :href="route('admin.study_programs.edit', program.id)"
                                              class="text-indigo-600 hover:text-indigo-900 transition-colors p-1 rounded-md hover:bg-indigo-50"
                                              title="Editar">
                                            <Edit class="w-5 h-5" />
                                        </Link>
                                        <button @click="deleteStudyProgram(program.id, program.name)"
                                                :disabled="deleteForm.processing"
                                                class="text-red-600 hover:text-red-900 transition-colors p-1 rounded-md hover:bg-red-50"
                                                title="Eliminar">
                                            <Trash2 class="w-5 h-5" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="studyPrograms.data.length === 0">
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No hay programas de estudio registrados.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div v-if="studyPrograms.last_page > 1" class="flex justify-between items-center px-6 py-4 border-t border-gray-200">
                    <div class="text-sm text-gray-600">
                        Mostrando {{ studyPrograms.data.length }} de {{ studyPrograms.total }} programas.
                    </div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <template v-for="(link, index) in studyPrograms.links" :key="index">
                            <Link v-if="link.url"
                                :href="link.url"
                                :class="{
                                    'bg-blue-600 text-white hover:bg-blue-700': link.active,
                                    'bg-white text-gray-700 hover:bg-gray-50': !link.active,
                                    'rounded-l-md': index === 0,
                                    'rounded-r-md': index === studyPrograms.links.length - 1,
                                }"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium"
                                v-html="link.label">
                            </Link>
                            <span v-else
                                :class="{
                                    'bg-white text-gray-700 pointer-events-none opacity-50': true, // Siempre deshabilitado
                                    'rounded-l-md': index === 0,
                                    'rounded-r-md': index === studyPrograms.links.length - 1,
                                }"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium"
                                v-html="link.label">
                            </span>
                        </template>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>
