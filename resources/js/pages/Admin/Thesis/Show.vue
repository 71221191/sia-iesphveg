<script setup>
import { useForm, Head } from '@inertiajs/vue3';
import {
    Users,
    UserCheck,
    ShieldCheck,
    AlertCircle,
    Save,
    GraduationCap // <--- Esta es la palabra que falta
} from 'lucide-vue-next';

const props = defineProps({
    project: Object,
    teachers: Array // Docentes para elegir
});

const advisorForm = useForm({ advisor_id: props.project.advisor_id || '' });

// Formulario para los 3 Jurados
const jurorsForm = useForm({
    jurors: [
        { teacher_id: props.project.jurors?.find(j => j.role === 'presidente')?.teacher_id || '', role: 'presidente' },
        { teacher_id: props.project.jurors?.find(j => j.role === 'secretario')?.teacher_id || '', role: 'secretario' },
        { teacher_id: props.project.jurors?.find(j => j.role === 'vocal')?.teacher_id || '', role: 'vocal' },
    ]
});

const submitAdvisor = () => { advisorForm.patch(route('admin.thesis.assign-advisor', props.project.id)); };
const submitJurors = () => { jurorsForm.post(route('admin.thesis.assign-jurors', props.project.id)); };

const defenseForm = useForm({
    // Usamos el operador ?. para que si no hay acta, no explote y use vacío
    defense_date: props.project.defense_act?.defense_date || '',
    defense_time: props.project.defense_act?.defense_time || '',
    modality: props.project.defense_act?.modality || 'presencial',
    score: props.project.defense_act?.score || 0,
    result: props.project.defense_act?.result || 'pendiente',
});

const submitDefense = () => {
    defenseForm.post(route('admin.thesis.record-defense', props.project.id), {
        preserveScroll: true,
        onSuccess: () => alert('Resultado de sustentación registrado con éxito.')
    });
};

</script>

<template>
    <Head title="Gestionar Tesis" />
    <div class="p-8 max-w-6xl mx-auto space-y-8">
        <h1 class="text-3xl font-black text-gray-900 uppercase">Expediente de Grado</h1>

        <!-- Mensajes de Feedback -->
        <div v-if="$page.props.flash.success" class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-bold rounded shadow-sm animate-bounce">
            ✅ {{ $page.props.flash.success }}
        </div>

        <div v-if="$page.props.errors && Object.keys($page.props.errors).length > 0" class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 font-bold rounded shadow-sm">
            <p>⚠️ Hubo problemas con el registro:</p>
            <ul class="list-disc ml-5 text-xs font-medium">
                <li v-for="error in $page.props.errors" :key="error">{{ error }}</li>
            </ul>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Columna Izquierda: Datos del Proyecto -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h2 class="text-xs font-black text-gray-400 uppercase mb-4 tracking-widest">Información General</h2>
                    <p class="font-bold text-gray-800 uppercase leading-tight">{{ project.title }}</p>
                    <div class="mt-4 space-y-2 text-[10px] font-bold uppercase">
                        <div class="text-indigo-600 italic">{{ project.research_line }}</div>
                        <div v-for="author in project.authors" :key="author.id" class="text-gray-500"> Tesista: {{ author.full_name }}</div>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Asignación de Autoridades -->
            <div class="lg:col-span-2 space-y-8">
                <!-- PANEL DE ASESOR -->
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100">
                    <h2 class="font-black text-gray-900 uppercase text-lg mb-6 flex items-center">
                        <UserCheck class="mr-2 w-5 h-5 text-blue-600" /> Docente Asesor
                    </h2>
                    <form @submit.prevent="submitAdvisor" class="flex gap-4">
                        <select v-model="advisorForm.advisor_id" class="flex-1 border-gray-200 rounded-2xl text-xs">
                            <option value="">Seleccione al asesor...</option>
                            <option v-for="t in teachers" :key="t.id" :value="t.id">{{ t.last_name_p }} {{ t.names }}</option>
                        </select>
                        <button class="bg-gray-900 text-white px-6 rounded-2xl font-bold text-xs uppercase hover:bg-blue-600 transition">Asignar</button>
                    </form>
                </div>

                <!-- PANEL DE JURADOS (LOS 3 JUECES) -->
                <div class="bg-indigo-900 p-8 rounded-[2.5rem] shadow-2xl text-white">
                    <h2 class="font-black uppercase text-lg mb-6 flex items-center">
                        <ShieldCheck class="mr-2 w-6 h-6 text-indigo-400" /> Nombramiento de Jurado Calificador
                    </h2>
                    <form @submit.prevent="submitJurors" class="space-y-4">
                        <div v-for="(juror, index) in jurorsForm.jurors" :key="index" class="grid grid-cols-3 items-center gap-4">
                            <span class="text-[10px] font-black uppercase opacity-60">{{ juror.role }}</span>
                            <select v-model="juror.teacher_id" class="col-span-2 bg-white/10 border-white/20 rounded-xl text-xs text-white focus:bg-white focus:text-gray-900">
                                <option value="" class="text-gray-900">Seleccione docente...</option>
                                <option v-for="t in teachers" :key="t.id" :value="t.id" class="text-gray-900">{{ t.last_name_p }} {{ t.names }}</option>
                            </select>
                        </div>

                        <div v-if="jurorsForm.errors.error" class="bg-red-500/20 border border-red-500 text-red-100 p-3 rounded-xl text-[10px] font-bold italic">
                            {{ jurorsForm.errors.error }}
                        </div>

                        <button :disabled="jurorsForm.processing" class="w-full mt-4 bg-white text-indigo-900 py-4 rounded-2xl font-black uppercase text-xs shadow-xl hover:bg-indigo-50 transition">
                            {{ jurorsForm.processing ? 'PROCESANDO...' : 'OFICIALIZAR JURADO CALIFICADOR' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- PANEL DE SUSTENTACIÓN -->
        <div v-if="project.jurors.length === 3" class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-indigo-100 mt-8">
            <h2 class="font-black text-gray-900 uppercase text-lg mb-6 flex items-center">
                <GraduationCap class="mr-2 w-6 h-6 text-indigo-600" /> Acta de Sustentación Final
            </h2>

            <form @submit.prevent="submitDefense" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Fecha y Hora</label>
                    <div class="flex space-x-2">
                        <input v-model="defenseForm.defense_date" type="date" class="w-full border-gray-200 rounded-xl text-xs" />
                        <input v-model="defenseForm.defense_time" type="time" class="w-full border-gray-200 rounded-xl text-xs" />
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Calificación (0-20)</label>
                    <input v-model="defenseForm.score" type="number" step="0.1" class="w-full border-gray-200 rounded-xl text-sm font-bold text-blue-600" />
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Resultado Final</label>
                    <select v-model="defenseForm.result" class="w-full border-gray-200 rounded-xl text-xs font-bold">
                        <option value="pendiente">PENDIENTE</option>
                        <option value="aprobado" class="text-green-600">APROBADO</option>
                        <option value="desaprobado" class="text-red-600">DESAPROBADO</option>
                    </select>
                </div>

                <div class="md:col-span-3 flex justify-end">
                    <button class="bg-indigo-600 text-white px-10 py-3 rounded-2xl font-black text-xs uppercase shadow-lg hover:bg-indigo-700 transition">
                        {{ defenseForm.processing ? 'GUARDANDO...' : 'REGISTRAR RESULTADO Y CERRAR EXPEDIENTE' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
