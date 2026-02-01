<script setup>
import { ref } from 'vue';
import { useForm, router, Head } from '@inertiajs/vue3';
import { FileSearch, CheckCircle, AlertCircle, XCircle, Eye } from 'lucide-vue-next';

const props = defineProps({
    files: Object,
    currentStatus: String
});

const isModalOpen = ref(false);
const selectedFile = ref(null);
const showFeedbackField = ref(false);

const form = useForm({
    status: '',
    feedback: ''
});

const openModal = (file) => {
    selectedFile.value = file;
    form.feedback = file.feedback || '';
    showFeedbackField.value = false;
    isModalOpen.value = true;
};

const processFile = (status) => {
    if (status === 'observed' && !showFeedbackField.value) {
        showFeedbackField.value = true;
        return;
    }
    form.status = status;
    form.patch(route('head_of_area.portfolio.update', selectedFile.value.id), {
        onSuccess: () => isModalOpen.value = false
    });
};

const changeTab = (status) => {
    router.get(route('head_of_area.portfolio.index'), { status });
};
</script>

<template>
    <Head title="Validación de Portafolio" />
    <div class="p-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-black text-gray-900 mb-8 uppercase tracking-tight">Revisión de Portafolio Docente</h1>

            <!-- TABS -->
            <div class="flex space-x-2 mb-6">
                <button v-for="s in ['pending', 'approved', 'observed']" :key="s"
                    @click="changeTab(s)"
                    :class="currentStatus === s ? 'bg-indigo-600 text-white shadow-lg' : 'bg-white text-gray-500 border'"
                    class="px-6 py-2 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all">
                    {{ s === 'pending' ? 'Pendientes' : (s === 'approved' ? 'Aprobados' : 'Observados') }}
                </button>
            </div>

            <!-- TABLA -->
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-900 text-white text-[10px] uppercase font-black tracking-widest">
                            <th class="p-4">Docente / Curso</th>
                            <th class="p-4">Tipo de Doc.</th>
                            <th class="p-4">Fecha Subida</th>
                            <th class="p-4 text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr v-for="file in files.data" :key="file.id" class="hover:bg-indigo-50/30 transition">
                            <td class="p-4">
                                <div class="font-black text-gray-900 uppercase text-xs">{{ file.section.teacher.names }} {{ file.section.teacher.last_name_p }}</div>
                                <div class="text-[10px] text-indigo-600 font-bold uppercase">{{ file.section.course.name }} ({{ file.section.name }})</div>
                            </td>
                            <td class="p-4">
                                <span class="bg-gray-100 px-2 py-1 rounded text-[10px] font-black uppercase text-gray-500 italic">{{ file.type }}</span>
                            </td>
                            <td class="p-4 text-xs text-gray-400 font-mono">
                                {{ new Date(file.created_at).toLocaleString() }}
                            </td>
                            <td class="p-4 text-center">
                                <button @click="openModal(file)" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold text-[10px] uppercase hover:bg-indigo-700 transition">
                                    REVISAR PDF
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MODAL DE VISUALIZACIÓN -->
        <div v-if="isModalOpen" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-[2.5rem] w-full max-w-5xl max-h-[95vh] overflow-hidden flex flex-col shadow-2xl">
                <div class="p-6 border-b flex justify-between items-center bg-gray-50">
                    <div>
                        <h2 class="font-black text-gray-900 uppercase text-lg">{{ selectedFile.name }}</h2>
                        <p class="text-xs text-indigo-500 font-bold uppercase">{{ selectedFile.section.course.name }}</p>
                    </div>
                    <button @click="isModalOpen = false" class="text-gray-400 hover:text-red-500 text-2xl font-black">×</button>
                </div>

                <div class="flex-1 bg-gray-200 p-4">
                    <iframe :src="'/storage/' + selectedFile.file_path" class="w-full h-full rounded-xl shadow-lg border-none" style="min-height: 500px;"></iframe>
                </div>

                <div class="p-6 border-t space-y-4">
                    <div v-if="showFeedbackField" class="animate-in fade-in slide-in-from-bottom-2">
                        <label class="block text-xs font-black text-red-600 uppercase mb-2 italic">Describa las observaciones para el docente:</label>
                        <textarea v-model="form.feedback" class="w-full border-2 border-red-100 rounded-2xl p-4 focus:ring-0 focus:border-red-400" rows="3"></textarea>
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="space-x-2">
                            <button @click="processFile('observed')" class="bg-red-50 text-red-700 px-6 py-3 rounded-xl font-bold text-xs uppercase hover:bg-red-100 transition">
                                {{ showFeedbackField ? 'CONFIRMAR OBSERVACIÓN' : 'OBSERVAR DOCUMENTO' }}
                            </button>
                            <button v-if="showFeedbackField" @click="showFeedbackField = false" class="text-gray-400 font-bold text-xs">Cancelar</button>
                        </div>
                        <button @click="processFile('approved')" class="bg-green-600 text-white px-10 py-3 rounded-xl font-black text-xs uppercase shadow-lg shadow-green-100 hover:bg-green-700 transition">
                            APROBAR SÍLABO / DOCUMENTO
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>