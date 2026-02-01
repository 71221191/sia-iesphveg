<script setup>
import { Head } from '@inertiajs/vue3';
import { BookOpen, AlertTriangle, CheckCircle } from 'lucide-vue-next';

const props = defineProps({
    progress: Array,
    studentName: String,
    periodName: String
});
</script>

<template>
    <Head title="Mi Progreso Académico" />

    <div class="p-8 max-w-6xl mx-auto">
        <h1 class="text-3xl font-black text-gray-900 mb-2 uppercase">Mi Progreso Académico</h1>
        <p class="text-gray-500 mb-8 font-mono">Periodo Actual: {{ periodName }}</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div v-for="item in progress" :key="item.course_code" 
                 class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-1 leading-tight">{{ item.course_name }}</h2>
                    <p class="text-xs text-gray-400 font-mono mb-4 uppercase">{{ item.course_code }} | Sección {{ item.section }}</p>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Card de Nota -->
                        <div class="bg-gray-50 p-4 rounded-2xl text-center">
                            <span class="text-[10px] font-black text-gray-400 uppercase block mb-1">Nota Actual</span>
                            <span class="text-3xl font-black" :class="item.current_grade >= 11 ? 'text-green-600' : 'text-red-500'">
                                {{ item.current_grade ? String(item.current_grade).padStart(2, '0') : '--' }}
                            </span>
                        </div>

                        <!-- Card de Asistencia -->
                        <div class="p-4 rounded-2xl text-center" :class="item.attendance.is_danger ? 'bg-red-50' : 'bg-blue-50'">
                            <span class="text-[10px] font-black uppercase block mb-1" :class="item.attendance.is_danger ? 'text-red-400' : 'text-blue-400'">
                                Inasistencias
                            </span>
                            <span class="text-3xl font-black" :class="item.attendance.is_danger ? 'text-red-600' : 'text-blue-600'">
                                {{ item.attendance.percentage }}%
                            </span>
                        </div>
                    </div>

                    <!-- Alerta de Riesgo DPI -->
                    <div v-if="item.attendance.is_danger" class="mt-4 p-3 bg-red-600 text-white rounded-xl flex items-center justify-center animate-pulse">
                        <AlertTriangle class="w-4 h-4 mr-2" />
                        <span class="text-[10px] font-black uppercase">¡RIESGO DE JALAR POR FALTAS (DPI)!</span>
                    </div>
                    
                    <div v-else class="mt-4 flex justify-between items-center text-[10px] font-bold text-gray-400">
                        <span>Faltas: {{ item.attendance.absences }} / {{ item.attendance.total_planned }} permitidas</span>
                        <span class="text-green-500 flex items-center"><CheckCircle class="w-3 h-3 mr-1" /> AL DÍA</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>