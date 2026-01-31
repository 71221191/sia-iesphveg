<script setup>
// 1. IMPORTACIONES FALTANTES
import { Link } from '@inertiajs/vue3';
import { Users, BookOpen } from 'lucide-vue-next'; // Aquí traemos los iconos
import { computed } from 'vue';

// 2. RECIBIR LOS DATOS DEL CONTROLADOR (La parte que faltaba)
const props = defineProps({
    sections: {
        type: Array,
        default: () => []
    }
});
</script>

<template>
    <div class="p-8 max-w-7xl mx-auto">
        <h1 class="text-3xl font-black text-gray-900 mb-8 uppercase tracking-tight">Mis Secciones Asignadas</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="section in sections" :key="section.id"
                 class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] font-black uppercase">
                            Ciclo {{ section.course.cycle }}
                        </span>
                        <span :class="section.is_closed ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'"
                              class="px-3 py-1 rounded-full text-[10px] font-black uppercase">
                            {{ section.is_closed ? 'Acta Cerrada' : 'Abierta' }}
                        </span>
                    </div>

                    <h2 class="text-xl font-bold text-gray-900 mb-1 leading-tight">{{ section.course.name }}</h2>
                    <p class="text-sm text-gray-500 mb-4 font-mono">{{ section.course.code }} | Sección {{ section.name }}</p>

                    <div class="flex items-center text-xs text-gray-400 mb-6">
                        <Users class="w-4 h-4 mr-1" />
                        <span>Alumnos matriculados: {{ section.enrollment_details_count || 0 }}</span>
                    </div>

                    <Link :href="route('teacher.sections.show', section.id)"
                          class="block w-full text-center bg-gray-900 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                        {{ section.is_closed ? 'Ver Calificaciones' : 'Registrar Notas' }}
                    </Link>
                    <Link :href="route('teacher.sections.configure', section.id)"
                        class="mt-2 block w-full text-center border-2 border-gray-200 text-gray-600 py-2 rounded-xl text-xs font-bold hover:bg-gray-50 transition">
                        ⚙️ CONFIGURAR COMPETENCIAS
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
