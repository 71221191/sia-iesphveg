<script setup lang="ts">
import { ref, computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { CheckCircle2, ChevronRight, ChevronLeft, BookOpen, UserCircle, AlertCircle } from 'lucide-vue-next'; // Agrega BookOpen y UserCircle
import { route } from 'ziggy-js';

const props = defineProps<{
  currentPeriod: string;
  currentPeriodId: number;
  availableSections: { cycle: string; [key: string]: any }[];
  studentStudyPlanId: number | null;
}>();

// Formulario para las selecciones de matrícula
const form = useForm({
    selected_sections: [] as number[], // IDs de las secciones que el alumno selecciona
    academic_period_id: props.currentPeriodId, // Usamos el ID real aquí
});

const submitEnrollment = () => {
    form.post(route('enrollment.store'), {
        onSuccess: () => {
            // Puedes mostrar un toast o redireccionar más específicamente
        },
        onError: (errors) => {
            // Manejar errores de validación del backend
            console.error('Errores de matrícula:', errors);
        }
    });
};

// Puedes añadir lógica para filtrar cursos por ciclo, buscar, etc.
const sectionsByCycle = computed(() => {
    const grouped: Record<string, any[]> = {};
    props.availableSections.forEach(section => {
        if (!grouped[section.cycle]) {
            grouped[section.cycle] = [];
        }
        grouped[section.cycle].push(section);
    });
    // Ordenar los ciclos para una mejor presentación
    return Object.keys(grouped).sort((a, b) => parseInt(a) - parseInt(b)).reduce((obj, key) => {
        obj[key] = grouped[key];
        return obj;
    }, {} as Record<string, any[]>);
});

</script>

<template>
    <Head title="Matrícula Online" />

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="max-w-6xl mx-auto">

            <!-- ENCABEZADO -->
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Proceso de Matrícula Online</h1>
                <p class="mt-2 text-gray-600">
                    Selecciona tus cursos para el período <span class="font-bold text-blue-600">{{ currentPeriod }}</span>
                </p>
            </div>

            <!-- BLOQUE GENERAL DE ERRORES (como el que ya tienes en socioeconomic/Create.vue) -->
            <div v-if="Object.keys(form.errors).length > 0" class="bg-red-50 border border-red-300 text-red-800 px-6 py-4 rounded-lg mb-8 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <AlertCircle class="w-5 h-5 shrink-0" />
                    <h3 class="font-bold text-lg">Por favor, corrige los siguientes errores de matrícula:</h3>
                </div>
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    <!-- Aquí se listarán los errores que el controlador devuelve -->
                    <li v-for="(error, field) in form.errors" :key="field">
                        <!-- Si el error viene como array, une los mensajes -->
                        <template v-if="Array.isArray(error)">
                            <span v-for="(subError, subIndex) in error" :key="subIndex">{{ subError }}</span>
                        </template>
                        <template v-else>
                            {{ error }}
                        </template>
                    </li>
                </ul>
            </div>
            <!-- FIN BLOQUE GENERAL DE ERRORES -->


            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden p-6 sm:p-10">
                <form @submit.prevent="submitEnrollment">
                    <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-6">Cursos Disponibles por Ciclo</h2>

                    <div v-if="Object.keys(sectionsByCycle).length === 0" class="text-center text-gray-600 py-8">
                        <BookOpen class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                        <p>No hay cursos disponibles para matrícula en este momento.</p>
                        <p class="text-sm mt-2">Contacta a Secretaría Académica si crees que esto es un error.</p>
                    </div>

                    <div v-for="(sections, cycle) in sectionsByCycle" :key="cycle" class="mb-8">
                        <h3 class="text-lg font-bold text-blue-700 mb-4">Ciclo {{ cycle }}</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Seleccionar
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Código
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Curso
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Créditos
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
                                            Disponibles
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="section in sections" :key="section.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox"
                                                   :value="section.id"
                                                   v-model="form.selected_sections"
                                                   :disabled="section.is_full"
                                                   class="form-checkbox h-5 w-5 text-blue-600 rounded">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ section.course_code }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ section.course_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ section.credits }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ section.section_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ section.teacher_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ section.vacancy_limit }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm"
                                            :class="{ 'text-red-600 font-bold': section.remaining_vacancies <= 0, 'text-green-600': section.remaining_vacancies > 0 }">
                                            {{ section.remaining_vacancies }}
                                            <span v-if="section.remaining_vacancies <= 0">(Lleno)</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Botón de Matricularse -->
                    <div class="mt-10 flex justify-end items-center pt-6 border-t border-gray-100">
                        <button
                            type="submit"
                            :disabled="form.processing || form.selected_sections.length === 0"
                            :class="{
                                'bg-blue-600 hover:bg-blue-700 text-white': !form.processing && form.selected_sections.length > 0,
                                'bg-gray-300 text-gray-500 cursor-not-allowed': form.processing || form.selected_sections.length === 0
                            }"
                            class="flex items-center px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all transform hover:scale-105"
                        >
                            <CheckCircle2 class="w-5 h-5 mr-2" />
                            {{ form.processing ? 'Procesando...' : 'Matricularme Ahora' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
