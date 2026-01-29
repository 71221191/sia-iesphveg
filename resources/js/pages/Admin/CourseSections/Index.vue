<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Plus, Edit, Trash2, CheckCircle2, AlertCircle, BookOpen, UserCircle, XCircle } from 'lucide-vue-next';
import { computed } from 'vue';
import { route } from 'ziggy-js';

// --- Función de conversión de Arábigos a Romanos ---
const toRoman = (num: string | number | null): string => {
    if (num === null) return 'N/A'; // O simplemente '';
    const n = typeof num === 'string' ? parseInt(num, 10) : num;
    if (isNaN(n) || n <= 0 || n > 10) return String(num);

    const romanMap: Record<number, string> = {
        1: 'I', 2: 'II', 3: 'III', 4: 'IV', 5: 'V',
        6: 'VI', 7: 'VII', 8: 'VIII', 9: 'IX', 10: 'X'
    };
    return romanMap[n] || String(num);
};
// ---------------------------------------------------


const props = defineProps<{
    courseSections: {
        data: any[];
        links: any[]; // Para paginación
        current_page: number;
        last_page: number;
        total: number;
    };
    flash: { success?: string; error?: string }; // Para mensajes flash
}>();

// Formulario para eliminar
const deleteForm = useForm({});

const deleteCourseSection = (sectionId: number, sectionName: string, courseName: string) => {
    if (confirm(`¿Estás seguro de que quieres ELIMINAR la sección "${sectionName}" del curso "${courseName}"? Esta acción no se puede deshacer y puede afectar a matrículas asociadas.`)) {
        deleteForm.delete(route('admin.course_sections.destroy', sectionId), {
            preserveScroll: true,
            onSuccess: () => {
                // Mensaje de éxito se mostrará vía flash
            },
            onError: (errors) => {
                console.error('Error al eliminar sección de curso:', errors);
                alert(props.flash.error || 'Hubo un error al intentar eliminar la sección de curso.');
            }
        });
    }
};

// Computed para mostrar la relación del curso y el plan de estudio
const getCoursePlanInfo = (section: any) => {
    if (section.course && section.course.study_plan && section.course.study_plan.study_program) {
        // Asegúrate de que section.course.cycle exista
        const cycleRoman = section.course.cycle ? toRoman(section.course.cycle) : 'N/A';
        return `${section.course.name} (${section.course.code}) - Plan: ${section.course.study_plan.name} (${section.course.study_plan.study_program.short_name}) [Ciclo ${cycleRoman}]`;
    }
    return section.course?.name || 'Curso Desconocido';
};

</script>

<template>
    <Head title="Secciones de Cursos" />

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="max-w-7xl mx-auto">

            <!-- ENCABEZADO -->
            <div class="flex justify-between items-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Gestión de Secciones de Cursos</h1>
                <Link :href="route('admin.course_sections.create')"
                      class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <Plus class="w-5 h-5 mr-2" />
                    Nueva Sección
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


            <!-- TABLA DE SECCIONES DE CURSOS -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Período
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Curso / Plan
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Sección
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Docente
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Vacantes
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acta Cerrada
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Acciones</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="section in courseSections.data" :key="section.id">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ section.academic_period.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ getCoursePlanInfo(section) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ section.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span v-if="section.teacher && section.teacher.person">
                                        {{ section.teacher.person.names }} {{ section.teacher.person.last_name_p }}
                                    </span>
                                    <span v-else-if="section.teacher">{{ section.teacher.name }}</span>
                                    <span v-else class="text-red-500">Sin Docente</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ section.vacancy_limit }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span v-if="section.is_closed" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        SÍ ({{ section.acta_number || 'N/A' }})
                                    </span>
                                    <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        NO
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center space-x-2">
                                        <Link :href="route('admin.course_sections.edit', section.id)"
                                              class="text-indigo-600 hover:text-indigo-900 transition-colors p-1 rounded-md hover:bg-indigo-50"
                                              title="Editar">
                                            <Edit class="w-5 h-5" />
                                        </Link>
                                        <button @click="deleteCourseSection(section.id, section.name, section.course?.name || 'curso desconocido')"
                                                :disabled="deleteForm.processing"
                                                class="text-red-600 hover:text-red-900 transition-colors p-1 rounded-md hover:bg-red-50"
                                                title="Eliminar">
                                            <Trash2 class="w-5 h-5" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="courseSections.data.length === 0">
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No hay secciones de cursos registrados.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div v-if="courseSections.last_page > 1" class="flex justify-between items-center px-6 py-4 border-t border-gray-200">
                    <div class="text-sm text-gray-600">
                        Mostrando {{ courseSections.data.length }} de {{ courseSections.total }} períodos.
                    </div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <template v-for="(link, index) in courseSections.links" :key="index">
                            <!-- Si link.url es null, renderiza un span deshabilitado -->
                            <span v-if="link.url === null"
                                  :class="{
                                      'rounded-l-md': index === 0,
                                      'rounded-r-md': index === courseSections.links.length - 1,
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
                                    'rounded-r-md': index === courseSections.links.length - 1,
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
