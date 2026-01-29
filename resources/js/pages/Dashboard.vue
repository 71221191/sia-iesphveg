<script setup lang="ts"> // Asegúrate de que sea <script setup> o <script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue'; // Asegúrate de importar ref y computed si los usas para algo más


// --- FUNCIÓN DE CONVERSIÓN ARÁBIGOS A ROMANOS ---
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
// ------------------------------------------------


// Recibe auth y student_info como props separadas
const { auth, student_info } = usePage().props;

// La variable 'student' ahora será 'student_info' directamente
// ya que viene con toda la información consolidada.
// const student = auth.student_info; // Ya no necesitas esto, usas student_info directamente
</script>

<template>
    <Head title="Mi Panel Académico" />

    <AppLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Panel Académico - IESP HVEG
            </h2>
        </template>

        <div class="py-12 bg-gray-100 min-h-screen">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <!-- 1. Ficha de Bienvenida (Card Principal) -->
                <!-- ¡CRÍTICO! Usar v-if="student_info" -->
                <div v-if="student_info" class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-8 mb-6 border-l-8 border-blue-600">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div>
                            <p class="text-sm font-bold text-blue-600 uppercase tracking-widest">Bienvenido(a) estudiante</p>
                            <!-- Usar student_info directamente -->
                            <h3 class="text-3xl font-black text-gray-900">{{ student_info.names }} {{ student_info.last_name_p }}</h3>
                            <p class="text-lg text-gray-600">
                                {{ student_info.program_name }}
                                <span v-if="student_info.current_cycle">| Ciclo {{ toRoman(student_info.current_cycle) }}</span> <!-- Convertir a romano -->
                                <span v-if="student_info.current_section_label"> - Sección "{{ student_info.current_section_label }}"</span>
                            </p>
                        </div>
                        <div class="mt-4 md:mt-0 bg-blue-50 p-4 rounded-lg border border-blue-100">
                            <p class="text-xs text-blue-800 font-bold uppercase">Estado de Matrícula</p>
                            <p class="text-sm text-blue-600 font-medium">{{ student_info.approval_resolution }}</p>
                        </div>
                    </div>
                </div>
                <div v-else class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-8 mb-6 border-l-8 border-yellow-600">
                    <p class="text-lg text-yellow-800">
                        ¡Bienvenido! No se pudo cargar su información de estudiante. Si es alumno, contacte a soporte.
                    </p>
                </div>

                <!-- 2. Rejilla de Información Detallada (También envuelta en v-if="student_info") -->
                <div v-if="student_info" class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Columna: Datos Académicos -->
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <h4 class="font-bold text-gray-800 mb-4 border-b pb-2">Información Académica</h4>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500 uppercase">DNI / Código</p>
                                <p class="font-medium">{{ student_info.dni }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Resolución de Beca</p>
                                <p class="font-medium text-green-600">{{ student_info.scholarship_resolution || 'No aplica' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Columna: Situación Social -->
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <h4 class="font-bold text-gray-800 mb-4 border-b pb-2">Bienestar Estudiantil</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <p class="text-sm text-gray-600">¿Tiene hijos?</p>
                                <span :class="student_info.has_children ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-600'" class="px-2 py-1 rounded text-xs font-bold">
                                    {{ student_info.has_children ? 'SÍ (' + student_info.children_count + ')' : 'NO' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-sm text-gray-600">Situación Laboral</p>
                                <span :class="student_info.has_work ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-600'" class="px-2 py-1 rounded text-xs font-bold">
                                    {{ student_info.has_work ? 'TRABAJA (' + student_info.work_type + ')' : 'NO TRABAJA' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Columna: Investigación (RF-17) -->
                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <h4 class="font-bold text-gray-800 mb-4 border-b pb-2">Investigación</h4>
                        <p class="text-xs text-gray-500 uppercase mb-1">Proyecto de Investigación</p>
                        <p class="text-sm leading-tight italic text-gray-700">
                            "{{ student_info.project_name || 'Sin proyecto registrado' }}"
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </AppLayout>
</template>
