<script setup>
import { useForm, Head } from '@inertiajs/vue3';
import { ClipboardList, Save, School, User } from 'lucide-vue-next';

const props = defineProps({
    assignments: Array
});

// Usamos un array de formularios para cada alumno (para guardar independiente)
const forms = props.assignments.map(a => useForm({
    institute_score: a.evaluation?.institute_score || 0,
    school_score: a.evaluation?.school_score || 0,
    observations: a.evaluation?.observations || '',
}));

const submit = (index, assignmentId) => {
    forms[index].post(route('teacher.practice.store', assignmentId), {
        preserveScroll: true
    });
};
</script>

<template>
    <Head title="Supervisión de Prácticas" />
    <div class="p-8 bg-gray-50 min-h-screen">
        <h1 class="text-3xl font-black text-gray-900 mb-8 uppercase tracking-tighter">Evaluación de Práctica Pre-Profesional</h1>

        <div class="space-y-6">
            <div v-for="(item, index) in assignments" :key="item.id" 
                 class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-center">
                    
                    <!-- Información del Alumno y Colegio -->
                    <div class="lg:col-span-1">
                        <div class="font-bold text-gray-900 uppercase text-sm mb-1">{{ item.student.last_name_p }} {{ item.student.names }}</div>
                        <div class="text-[10px] text-indigo-600 font-bold flex items-center">
                            <School class="w-3 h-3 mr-1" /> {{ item.center.name }}
                        </div>
                        <div class="text-[9px] text-gray-400 mt-1 italic">Aula: {{ item.grade_and_section }}</div>
                    </div>

                    <!-- Inputs de Notas -->
                    <div class="lg:col-span-2 grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-3 rounded-2xl border border-gray-100">
                            <label class="block text-[8px] font-black text-gray-400 uppercase mb-1">Nota Instituto (Supervisor)</label>
                            <input v-model="forms[index].institute_score" type="number" min="0" max="20" class="w-full bg-transparent border-none text-xl font-black text-blue-600 focus:ring-0 p-0 text-center" />
                        </div>
                        <div class="bg-gray-50 p-3 rounded-2xl border border-gray-100">
                            <label class="block text-[8px] font-black text-gray-400 uppercase mb-1">Nota Colegio (Prof. Aula)</label>
                            <input v-model="forms[index].school_score" type="number" min="0" max="20" class="w-full bg-transparent border-none text-xl font-black text-orange-600 focus:ring-0 p-0 text-center" />
                        </div>
                    </div>

                    <!-- Promedio y Botón -->
                    <div class="flex items-center justify-between lg:justify-around lg:col-span-1">
                        <div class="text-center">
                            <span class="text-[8px] font-black text-gray-400 uppercase block">Promedio Final</span>
                            <span class="text-3xl font-black text-gray-900">
                                {{ ((Number(forms[index].institute_score) + Number(forms[index].school_score)) / 2).toFixed(1) }}
                            </span>
                        </div>
                        <button @click="submit(index, item.id)" :disabled="forms[index].processing"
                                class="bg-gray-900 text-white p-4 rounded-2xl hover:bg-indigo-600 transition shadow-lg">
                            <Save class="w-6 h-6" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>