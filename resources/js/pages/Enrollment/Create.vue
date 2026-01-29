<script setup lang="ts">
import { ref, computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { CheckCircle2, ChevronRight, ChevronLeft, BookOpen, UserCircle, AlertCircle } from 'lucide-vue-next'; // Agrega BookOpen y UserCircle
import { route } from 'ziggy-js';

const props = defineProps<{
    requirements: {
        type: Object,
        default: () => ({
            can_enroll: false,
            details: { ficha: false, pago: false, biblioteca: false }
        })
    },
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

            <!-- Banner de Alerta si no puede matricularse -->
            <div v-if="!requirements.can_enroll" class="mb-6 bg-white border-l-4 border-red-500 p-4 shadow-md rounded-r-lg">
                <h3 class="text-red-800 font-bold mb-2 flex items-center">
                    <span class="mr-2">⚠️</span> Requisitos de Matrícula Pendientes
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Item Ficha -->
                    <div class="flex items-center p-3 rounded-lg" :class="requirements.details.ficha ? 'bg-green-100/50' : 'bg-white shadow-sm border border-red-200'">
                        <span class="mr-3">{{ requirements.details.ficha ? '✅' : '❌' }}</span>
                        <span class="text-sm font-medium" :class="requirements.details.ficha ? 'text-green-700' : 'text-red-700'">Ficha Socioeconómica</span>
                    </div>

                    <!-- Item Pago -->
                    <div class="flex items-center p-3 rounded-lg" :class="requirements.details.pago ? 'bg-green-100/50' : 'bg-white shadow-sm border border-red-200'">
                        <span class="mr-3">{{ requirements.details.pago ? '✅' : '❌' }}</span>
                        <span class="text-sm font-medium" :class="requirements.details.pago ? 'text-green-700' : 'text-red-700'">Pago de Matrícula</span>
                    </div>

                    <!-- Item Biblioteca -->
                    <div class="flex items-center p-3 rounded-lg" :class="requirements.details.biblioteca ? 'bg-green-100/50' : 'bg-white shadow-sm border border-red-200'">
                        <span class="mr-3">{{ requirements.details.biblioteca ? '✅' : '❌' }}</span>
                        <span class="text-sm font-medium" :class="requirements.details.biblioteca ? 'text-green-700' : 'text-red-700'">Sin deudas de Libros</span>
                    </div>
                </div>
                <p class="mt-3 text-xs text-gray-500 italic">
                    * Debes cumplir con todos los puntos para habilitar el botón de envío de matrícula.
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
                                    <tr v-for="section in sections" :key="section.id"
                                        :class="{
                                            'bg-green-50/50': section.status === 'passed',
                                            'bg-gray-50 opacity-70': section.status === 'locked',
                                            'bg-orange-50/30': section.status === 'no_vacancies'
                                        }">

                                        <!-- 1. Columna de Selección -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <!-- Solo mostramos checkbox si está DISPONIBLE -->
                                            <input v-if="section.status === 'available'"
                                                type="checkbox"
                                                :value="section.id"
                                                v-model="form.selected_sections"
                                                class="form-checkbox h-5 w-5 text-blue-600 rounded cursor-pointer">

                                            <!-- Si ya lo pasó, mostramos un check verde -->
                                            <span v-else-if="section.status === 'passed'" class="text-green-600 font-bold text-lg" title="Ya aprobado">
                                                <span class="sr-only">Aprobado</span> ✅
                                            </span>

                                            <!-- Si está bloqueado, mostramos un candado -->
                                            <span v-else-if="section.status === 'locked'" class="text-gray-400" :title="section.lock_reason">
                                                <span class="sr-only">Bloqueado</span> 🔒
                                            </span>

                                            <!-- Si está lleno -->
                                            <span v-else-if="section.status === 'no_vacancies'" class="text-orange-500" title="Sin vacantes">
                                                <span class="sr-only">Lleno</span> 🚫
                                            </span>
                                        </td>

                                        <!-- 2. Código -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm" :class="section.status === 'locked' ? 'text-gray-400' : 'text-gray-900'">
                                            {{ section.course_code }}
                                        </td>

                                        <!-- 3. Nombre del Curso + Motivo de Bloqueo -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <span :class="section.status === 'locked' ? 'text-gray-400' : 'text-gray-900'">
                                                {{ section.course_name }}
                                            </span>

                                            <!-- IMPORTANTE: Mostrar por qué no puede llevarlo -->
                                            <div v-if="section.status === 'locked'" class="text-[10px] text-red-500 italic mt-0.5">
                                                {{ section.lock_reason }}
                                            </div>
                                            <div v-if="section.status === 'passed'" class="text-[10px] text-green-600 font-bold mt-0.5 uppercase">
                                                Curso Aprobado
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ section.credits }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ section.section_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ section.teacher_name }}</td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ section.vacancy_limit }}</td>

                                        <!-- 4. Vacantes con Colores -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm"
                                            :class="{
                                                'text-red-600 font-bold': section.remaining_vacancies <= 0,
                                                'text-green-600': section.remaining_vacancies > 0
                                            }">
                                            {{ section.remaining_vacancies }}
                                            <span v-if="section.status === 'no_vacancies'" class="text-[10px] block">(Lleno)</span>
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
                            :disabled="form.processing || form.selected_sections.length === 0 || !requirements.can_enroll"
                            :class="{
                                'bg-blue-600 hover:bg-blue-700 text-white shadow-blue-200': !form.processing && form.selected_sections.length > 0 && requirements.can_enroll,
                                'bg-gray-300 text-gray-500 cursor-not-allowed shadow-none scale-100': form.processing || form.selected_sections.length === 0 || !requirements.can_enroll
                            }"
                            class="flex items-center px-8 py-3 rounded-xl font-bold shadow-lg transition-all transform hover:scale-105"
                        >
                            <CheckCircle2 v-if="requirements.can_enroll" class="w-5 h-5 mr-2" />
                            <Lock v-else class="w-5 h-5 mr-2" />
                            {{ form.processing ? 'Procesando...' : (requirements.can_enroll ? 'Matricularme Ahora' : 'Requisitos Pendientes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
