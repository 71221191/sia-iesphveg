<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Save, UserCheck, UserMinus, Clock } from 'lucide-vue-next';

const props = defineProps({
    session: Object,
    students: Array // Viene del AttendanceService que ya hicimos
});

const form = useForm({
    records: props.students.map(student => ({
        person_id: student.person_id,
        status: student.status // 'present' por defecto
    }))
});

const setAllStatus = (status) => {
    form.records.forEach(r => r.status = status);
};

const submit = () => {
    form.post(route('teacher.attendance.store-records', props.session.id));
};
</script>

<template>
    <Head title="Pasar Asistencia" />

    <div class="p-4 md:p-8 max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <Link :href="route('teacher.attendance.index', session.course_section_id)" class="text-sm font-bold text-gray-500 uppercase flex items-center mb-2">
                <ArrowLeft class="w-4 h-4 mr-1" /> Volver al historial
            </Link>
            <h1 class="text-2xl font-black text-gray-900 uppercase leading-tight">{{ session.topic }}</h1>
            <p class="text-gray-500 text-sm font-medium italic">Clase del {{ new Date(session.date).toLocaleDateString() }}</p>
        </div>

        <!-- Acciones Rápidas -->
        <div class="mb-4 flex justify-between items-center bg-gray-100 p-3 rounded-2xl border border-gray-200">
            <span class="text-[10px] font-black text-gray-500 uppercase ml-2">Marcar a todos como:</span>
            <div class="space-x-2">
                <button @click="setAllStatus('present')" class="px-3 py-1 bg-green-600 text-white text-[10px] font-bold rounded-lg uppercase">Presente</button>
                <button @click="setAllStatus('absent')" class="px-3 py-1 bg-red-600 text-white text-[10px] font-bold rounded-lg uppercase">Falta</button>
            </div>
        </div>

        <!-- Lista de Alumnos -->
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden mb-24">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-900 text-white text-[10px] tracking-widest uppercase font-black">
                        <th class="p-4">Estudiante</th>
                        <th class="p-4 text-center">Asistencia</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr v-for="(record, index) in form.records" :key="record.person_id" class="hover:bg-gray-50 transition">
                        <td class="p-4">
                            <div class="text-xs font-bold text-gray-900 uppercase">{{ props.students[index].full_name }}</div>
                        </td>
                        <td class="p-2">
                            <div class="flex justify-center items-center space-x-1">
                                <!-- Botón Presente -->
                                <button type="button" @click="record.status = 'present'"
                                    :class="record.status === 'present' ? 'bg-green-100 text-green-700 border-green-500' : 'bg-white text-gray-400 border-gray-200'"
                                    class="p-2 rounded-xl border-2 transition flex-1 flex flex-col items-center">
                                    <UserCheck class="w-5 h-5" />
                                    <span class="text-[8px] font-black uppercase mt-1">P</span>
                                </button>

                                <!-- Botón Tardanza -->
                                <button type="button" @click="record.status = 'late'"
                                    :class="record.status === 'late' ? 'bg-yellow-100 text-yellow-700 border-yellow-500' : 'bg-white text-gray-400 border-gray-200'"
                                    class="p-2 rounded-xl border-2 transition flex-1 flex flex-col items-center">
                                    <Clock class="w-5 h-5" />
                                    <span class="text-[8px] font-black uppercase mt-1">T</span>
                                </button>

                                <!-- Botón Falta -->
                                <button type="button" @click="record.status = 'absent'"
                                    :class="record.status === 'absent' ? 'bg-red-100 text-red-700 border-red-500' : 'bg-white text-gray-400 border-gray-200'"
                                    class="p-2 rounded-xl border-2 transition flex-1 flex flex-col items-center">
                                    <UserMinus class="w-5 h-5" />
                                    <span class="text-[8px] font-black uppercase mt-1">F</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Botón de Guardar Fijo al fondo (Sticky) -->
        <div class="fixed bottom-8 left-1/2 -translate-x-1/2 w-full max-w-md px-4">
            <button @click="submit" :disabled="form.processing"
                class="w-full bg-gray-900 text-white py-4 rounded-2xl font-black shadow-2xl hover:bg-blue-700 transition flex items-center justify-center space-x-3 transform active:scale-95">
                <Save class="w-6 h-6" />
                <span>{{ form.processing ? 'Sincronizando...' : 'GUARDAR ASISTENCIA' }}</span>
            </button>
        </div>
    </div>
</template>
