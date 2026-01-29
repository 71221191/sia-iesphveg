<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Save, ChevronLeft, AlertCircle } from 'lucide-vue-next';
import { ref, computed, watch } from 'vue';
import { route } from 'ziggy-js';

// --- Función de conversión de Arábigos a Romanos ---
const toRoman = (num: string | number | null): string => {
    if (num === null) return 'N/A'; // O simplemente '';
    const n = typeof num === 'string' ? parseInt(num, 10) : num;
    if (isNaN(n) || n <= 0 || n > 10) return String(num); // Mantiene el original si es inválido o fuera de rango 1-10

    const romanMap: Record<number, string> = {
        1: 'I', 2: 'II', 3: 'III', 4: 'IV', 5: 'V',
        6: 'VI', 7: 'VII', 8: 'VIII', 9: 'IX', 10: 'X'
    };
    return romanMap[n] || String(num); // Fallback al número original si no está en el mapa
};

const props = defineProps<{
    courses: any[]; // Lista de cursos
    academicPeriods: any[]; // Lista de periodos académicos
    teachers: any[]; // Lista de docentes
    studyPrograms: any[]; // <-- Nueva prop
    studyPlans: any[]; // <-- Nueva prop
}>();

// --- NUEVO LOG AL INICIO PARA VER DATOS CRUDOS ---
console.log('--- DEBUG INICIAL props.courses ---');
console.log(JSON.parse(JSON.stringify(props.courses.slice(0, 5)))); // Muestra los primeros 5 cursos para no sobrecargar
console.log('-----------------------------------');
// ------------------------------------------------

const form = useForm({
    course_id: null,
    academic_period_id: null,
    name: 'A', // Valor por defecto
    teacher_id: null,
    vacancy_limit: 25, // Valor por defecto
});

// --- NUEVOS REFS PARA LOS FILTROS EN CASCADA ---
const selectedStudyProgramId = ref(null);
const selectedStudyPlanId = ref(null);
const selectedCycle = ref(null);
const courseSearchQuery = ref(''); // Para el buscador de texto
// --- COMPUTED PROPERTIES PARA EL FILTRADO ---

// 1. Planes de estudio filtrados por programa
const filteredStudyPlans = computed(() => {
    if (!selectedStudyProgramId.value) {
        return props.studyPlans;
    }
    return props.studyPlans.filter(plan => plan.study_program_id === selectedStudyProgramId.value);
});

// 2. Cursos filtrados por plan de estudio y búsqueda de texto
const filteredCourses = computed(() => {
    let courses = props.courses;

    console.log('--- DEBUG FILTRO CURSOS ---');
    console.log('selectedStudyProgramId:', selectedStudyProgramId.value);
    console.log('selectedStudyPlanId:', selectedStudyPlanId.value);
    console.log('selectedCycle:', selectedCycle.value); // <--- VALOR DEL FILTRO DE CICLO
    console.log('courseSearchQuery:', courseSearchQuery.value);
    console.log('Cursos iniciales:', courses.length);

    // A. Filtrar por plan de estudio (o por programa si no hay plan específico)
    if (selectedStudyPlanId.value) {
        courses = courses.filter(course => course.study_plan_id === selectedStudyPlanId.value);
    } else if (selectedStudyProgramId.value) {
        const plansInSelectedProgram = props.studyPlans
            .filter(plan => plan.study_program_id === selectedStudyProgramId.value)
            .map(plan => plan.id);
        courses = courses.filter(course => plansInSelectedProgram.includes(course.study_plan_id));
    }

    // B. Filtrar por ciclo (¡NUEVO!)
    if (selectedCycle.value) {
        courses = courses.filter(course => {
                console.log(`  Comparando DB: '${course.cycle}' (Tipo: ${typeof course.cycle}) con Filtro: '${selectedCycle.value}' (Tipo: ${typeof selectedCycle.value}) -> Match: ${course.cycle === selectedCycle.value}`); // <-- MUESTRA EL TIPO
                return course.cycle === selectedCycle.value;
            });
    }
    console.log('Cursos después de filtro Ciclo:', courses.length);

    // C. Filtrar por búsqueda de texto
    if (courseSearchQuery.value) {
        const query = courseSearchQuery.value.toLowerCase();
        courses = courses.filter(course =>
            course.name.toLowerCase().includes(query) ||
            course.code.toLowerCase().includes(query)
        );
    }
    console.log('Cursos después de filtro Búsqueda:', courses.length);
    console.log('Cursos finales filtrados:', courses.length);
    console.log('---------------------------');

    return courses;
});

// Opcional: Generar lista de ciclos disponibles dinámicamente o usar un array fijo
const cycles = ref(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10']);
// --------------------------------------------

// --- WATCHERS PARA RESETEAR FILTROS EN CASCADA ---

// Cuando cambia la carrera, resetear el plan y el curso
watch(selectedStudyProgramId, (newValue, oldValue) => {
    if (newValue !== oldValue) {
        selectedStudyPlanId.value = null;
        selectedCycle.value = null;
        form.course_id = null;
    }
});

// Cuando cambia el plan, resetear el curso
watch(selectedStudyPlanId, (newValue, oldValue) => {
    if (newValue !== oldValue) {
        selectedCycle.value = null;
        form.course_id = null;
    }
});

// Cuando cambia el ciclo, resetear el curso (opcional, pero buena práctica)
watch(selectedCycle, (newValue, oldValue) => {
    if (newValue !== oldValue) {
        form.course_id = null;
    }
});

// -------------------------------------------------


const submit = () => {
    form.post(route('admin.course_sections.store'), {
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
    <Head title="Crear Sección de Curso" />

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="max-w-3xl mx-auto">

            <!-- ENCABEZADO -->
            <div class="mb-10">
                <Link :href="route('admin.course_sections.index')" class="text-blue-600 hover:text-blue-800 flex items-center mb-4">
                    <ChevronLeft class="w-4 h-4 mr-1" /> Volver a la lista
                </Link>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Crear Nueva Sección de Curso</h1>
                <p class="mt-2 text-gray-600">Asocia un curso a un período, docente y define las vacantes.</p>
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
                            <label for="academic_period_id" class="block text-sm font-medium text-gray-700">Período Académico <span class="text-red-500">*</span></label>
                            <select id="academic_period_id" v-model="form.academic_period_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{ 'border-red-500': form.errors.academic_period_id }">
                                <option :value="null" disabled>Seleccione un período...</option>
                                <option v-for="period in academicPeriods" :key="period.id" :value="period.id">
                                    {{ period.name }} <span v-if="period.status === 'open'">(Abierto)</span>
                                </option>
                            </select>
                            <div v-if="form.errors.academic_period_id" class="text-sm text-red-600 mt-1">{{ form.errors.academic_period_id }}</div>
                        </div>

                        <!-- --- NUEVOS SELECTORES DE FILTRO (CASCADA) --- -->
                        <!-- --- SELECTORES DE FILTRO (CASCADA) --- -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="selected_program" class="block text-sm font-medium text-gray-700">Filtrar por Carrera</label>
                                <select id="selected_program" v-model="selectedStudyProgramId"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option :value="null">Todas las Carreras</option>
                                    <option v-for="program in studyPrograms" :key="program.id" :value="program.id">
                                        {{ program.name }} ({{ program.short_name }})
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label for="selected_plan" class="block text-sm font-medium text-gray-700">Filtrar por Plan de Estudio</label>
                                <select id="selected_plan" v-model="selectedStudyPlanId"
                                        :disabled="filteredStudyPlans.length === 0 && selectedStudyProgramId !== null"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option :value="null">Todos los Planes</option>
                                    <option v-for="plan in filteredStudyPlans" :key="plan.id" :value="plan.id">
                                        {{ plan.name }}
                                    </option>
                                </select>
                                <p v-if="filteredStudyPlans.length === 0 && selectedStudyProgramId !== null" class="mt-1 text-xs text-yellow-600">
                                    No hay planes para la carrera seleccionada.
                                </p>
                            </div>
                            <div>
                                <label for="selected_cycle" class="block text-sm font-medium text-gray-700">Filtrar por Ciclo</label>
                                <select id="selected_cycle" v-model="selectedCycle"
                                        :disabled="filteredCourses.length === 0 && (selectedStudyPlanId !== null || selectedStudyProgramId !== null)"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option :value="null">Todos los Ciclos</option>
                                    <option v-for="cycleOption in cycles" :key="cycleOption" :value="cycleOption">
                                        {{ toRoman(cycleOption) }}
                                    </option>
                                </select>
                                <p v-if="filteredCourses.length === 0 && (selectedStudyPlanId !== null || selectedStudyProgramId !== null)" class="mt-1 text-xs text-yellow-600">
                                    No hay ciclos para los filtros actuales.
                                </p>
                            </div>
                        </div>

                        <div>
                            <label for="course_search" class="block text-sm font-medium text-gray-700">Buscar Curso (Nombre o Código)</label>
                            <input type="text" id="course_search" v-model="courseSearchQuery"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="Ej: Álgebra, MAT101...">
                        </div>
                        <!-- --- FIN NUEVOS SELECTORES DE FILTRO --- -->


                        <!-- Selector de Curso (modificado para usar filteredCourses) -->
                        <div>
                            <label for="course_id" class="block text-sm font-medium text-gray-700">Curso <span class="text-red-500">*</span></label>
                            <select id="course_id" v-model="form.course_id"
                                    :disabled="filteredCourses.length === 0"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{ 'border-red-500': form.errors.course_id }">
                                <option :value="null" disabled>Seleccione un curso...</option>
                                <option v-for="course in filteredCourses" :key="course.id" :value="course.id">
                                    {{ course.name }} (Ciclo {{ toRoman(course.cycle) }})
                                </option>
                            </select>
                            <div v-if="form.errors.course_id" class="text-sm text-red-600 mt-1">{{ form.errors.course_id }}</div>
                            <p v-if="filteredCourses.length === 0 && (selectedStudyPlanId !== null || selectedStudyProgramId !== null || selectedCycle !== null)" class="mt-1 text-xs text-yellow-600">
                                No hay cursos para los filtros seleccionados.
                            </p>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Sección <span class="text-red-500">*</span></label>
                            <input type="text" id="name" v-model="form.name"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   :class="{ 'border-red-500': form.errors.name }"
                                   placeholder="Ej: A, B, Única">
                            <div v-if="form.errors.name" class="text-sm text-red-600 mt-1">{{ form.errors.name }}</div>
                            <p class="mt-1 text-xs text-gray-500">Ejemplo: "A", "B", o "Única" si solo hay una sección.</p>
                        </div>

                        <div>
                            <label for="teacher_id" class="block text-sm font-medium text-gray-700">Docente Asignado (Opcional)</label>
                            <select id="teacher_id" v-model="form.teacher_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    :class="{ 'border-red-500': form.errors.teacher_id }">
                                <option :value="null">Sin asignar</option>
                                <option v-for="teacher in teachers" :key="teacher.id" :value="teacher.id">
                                    {{ teacher.name }}
                                </option>
                            </select>
                            <div v-if="form.errors.teacher_id" class="text-sm text-red-600 mt-1">{{ form.errors.teacher_id }}</div>
                        </div>

                        <div>
                            <label for="vacancy_limit" class="block text-sm font-medium text-gray-700">Límite de Vacantes <span class="text-red-500">*</span></label>
                            <input type="number" id="vacancy_limit" v-model="form.vacancy_limit" min="0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   :class="{ 'border-red-500': form.errors.vacancy_limit }">
                            <div v-if="form.errors.vacancy_limit" class="text-sm text-red-600 mt-1">{{ form.errors.vacancy_limit }}</div>
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
                            {{ form.processing ? 'Guardando...' : 'Guardar Sección' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
