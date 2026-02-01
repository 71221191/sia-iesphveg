<script setup>
import { useForm, Head } from '@inertiajs/vue3';
import { ClipboardCheck, UserPlus, Trash2, School, User } from 'lucide-vue-next';

const props = defineProps({
    assignments: Array,
    students: Array,
    teachers: Array,
    centers: Array,
    currentPeriod: Object
});

const form = useForm({
    academic_period_id: props.currentPeriod.id,
    student_id: '',
    teacher_id: '',
    practice_center_id: '',
    classroom_teacher_name: '',
    grade_and_section: '',
});

const submit = () => {
    form.post(route('admin.asignaciones-practica.store'), {
        onSuccess: () => form.reset('student_id', 'classroom_teacher_name', 'grade_and_section'),
    });
};
</script>

<template>
    <Head title="Asignaciones de Práctica" />
    <div class="p-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-black text-gray-900 mb-8 uppercase flex items-center tracking-tighter">
                <ClipboardCheck class="mr-3 w-8 h-8 text-indigo-600" />
                Asignación de Prácticas Pre-Profesionales
            </h1>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- FORMULARIO DE ASIGNACIÓN -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                        <h2 class="font-bold text-gray-800 mb-6 uppercase text-sm flex items-center">
                            <UserPlus class="mr-2 w-4 h-4 text-green-500" /> Nueva Asignación
                        </h2>
                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Estudiante (Practicante)</label>
                                <select v-model="form.student_id" class="w-full border-gray-200 rounded-xl text-xs">
                                    <option value="">Seleccione...</option>
                                    <option v-for="s in students" :key="s.id" :value="s.id">
                                        {{ s.last_name_p }} {{ s.names }}
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Centro de Práctica (I.E.)</label>
                                <select v-model="form.practice_center_id" class="w-full border-gray-200 rounded-xl text-xs">
                                    <option value="">Seleccione...</option>
                                    <option v-for="c in centers" :key="c.id" :value="c.id">
                                        {{ c.name }} ({{ c.level }})
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Docente Supervisor (IESP)</label>
                                <select v-model="form.teacher_id" class="w-full border-gray-200 rounded-xl text-xs">
                                    <option value="">Seleccione...</option>
                                    <option v-for="t in teachers" :key="t.id" :value="t.id">
                                        {{ t.last_name_p }} {{ t.names }}
                                    </option>
                                </select>
                            </div>

                            <div class="pt-2 border-t border-gray-50">
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1 italic text-right">Datos en el Colegio:</label>
                                <input v-model="form.classroom_teacher_name" type="text" placeholder="Prof. de Aula del Colegio" class="w-full border-gray-200 rounded-xl text-xs mb-2" />
                                <input v-model="form.grade_and_section" type="text" placeholder="Grado y Sección (Ej: 5to B)" class="w-full border-gray-200 rounded-xl text-xs" />
                            </div>

                            <button :disabled="form.processing" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold text-xs uppercase shadow-lg shadow-indigo-100">
                                REALIZAR ASIGNACIÓN
                            </button>
                        </form>
                    </div>
                </div>

                <!-- LISTADO DE ASIGNACIONES -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-900 text-white text-[10px] uppercase font-black tracking-widest">
                                    <th class="p-4">Estudiante / Colegio</th>
                                    <th class="p-4">Supervisor (IESP)</th>
                                    <th class="p-4 text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr v-for="item in assignments" :key="item.id" class="hover:bg-blue-50/50 transition">
                                    <td class="p-4">
                                        <div class="font-bold text-gray-900 uppercase text-xs flex items-center">
                                            <User class="w-3 h-3 mr-1 text-indigo-400" />
                                            {{ item.student.last_name_p }} {{ item.student.names }}
                                        </div>
                                        <div class="text-[10px] text-gray-500 flex items-center mt-1">
                                            <School class="w-3 h-3 mr-1 text-gray-300" />
                                            {{ item.center.name }} - {{ item.grade_and_section || 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-[10px] font-black text-indigo-600 uppercase">{{ item.teacher.last_name_p }} {{ item.teacher.names }}</div>
                                        <div class="text-[9px] text-gray-400 italic">Prof. Aula: {{ item.classroom_teacher_name || 'Sin asignar' }}</div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <button @click="$inertia.delete(route('admin.asignaciones-practica.destroy', item.id))" class="text-red-400 hover:text-red-600 p-2 transition">
                                            <Trash2 class="w-4 h-4" />
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="assignments.length === 0">
                                    <td colspan="3" class="p-12 text-center text-gray-400 italic">No hay estudiantes asignados a centros de práctica.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>