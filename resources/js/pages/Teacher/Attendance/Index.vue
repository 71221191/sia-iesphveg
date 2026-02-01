<script setup>
import { ref } from 'vue';
import { useForm, Head, Link } from '@inertiajs/vue3';
import { Calendar, Plus, ArrowLeft, ClipboardList, ChevronRight } from 'lucide-vue-next';

const props = defineProps({
    section: Object,
    sessions: Array
});

const isModalOpen = ref(false);

const form = useForm({
    date: new Date().toISOString().substr(0, 10), // Fecha de hoy por defecto
    topic: ''
});

const submit = () => {
    form.post(route('teacher.attendance.store-session', props.section.id), {
        onSuccess: () => {
            isModalOpen.value = false;
            form.reset('topic');
        }
    });
};
</script>

<template>
    <Head :title="'Asistencia - ' + section.course.name" />

    <div class="p-8 max-w-5xl mx-auto">
        <!-- Encabezado -->
        <div class="mb-8">
            <Link :href="route('teacher.sections.index')" class="text-sm font-bold text-gray-500 uppercase tracking-widest hover:text-blue-600 flex items-center mb-4">
                <ArrowLeft class="w-4 h-4 mr-1" /> Volver a mis cursos
            </Link>
            <div class="flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-black text-gray-900 uppercase italic">{{ section.course.name }}</h1>
                    <p class="text-gray-500 font-mono">Control de Asistencia | Sección {{ section.name }}</p>
                </div>
                <button @click="isModalOpen = true" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-black shadow-lg hover:bg-blue-700 transition transform hover:scale-105 flex items-center">
                    <Plus class="w-5 h-5 mr-2" /> REGISTRAR CLASE DE HOY
                </button>
            </div>
        </div>

        <!-- Lista de Sesiones -->
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="p-6 border-b bg-gray-50/50">
                <h2 class="font-black text-gray-700 uppercase text-xs tracking-widest flex items-center">
                    <Calendar class="w-4 h-4 mr-2" /> Historial de Sesiones
                </h2>
            </div>

            <div class="divide-y divide-gray-100">
                <div v-for="session in sessions" :key="session.id" class="p-4 hover:bg-blue-50/30 transition flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gray-100 p-3 rounded-xl text-gray-600">
                            <span class="block text-[10px] font-black uppercase leading-none">{{ new Date(session.date).toLocaleDateString('es-ES', { month: 'short' }) }}</span>
                            <span class="block text-xl font-black leading-none">{{ new Date(session.date).getDate() + 1 }}</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 uppercase text-sm">{{ session.topic }}</h3>
                            <span :class="session.is_executed ? 'text-green-600' : 'text-orange-500'" class="text-[10px] font-black uppercase tracking-tighter">
                                {{ session.is_executed ? '● Completada' : '○ Pendiente de firma' }}
                            </span>
                        </div>
                    </div>

                    <Link :href="route('teacher.attendance.show', session.id)" class="bg-white border border-gray-200 p-2 rounded-lg hover:border-blue-500 hover:text-blue-600 transition">
                        <ChevronRight class="w-5 h-5" />
                    </Link>
                </div>

                <div v-if="sessions.length === 0" class="p-20 text-center text-gray-400 italic">
                    No has registrado ninguna sesión de clase todavía.
                </div>
            </div>
        </div>

        <!-- MODAL PARA NUEVA SESIÓN -->
        <div v-if="isModalOpen" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden">
                <div class="p-6 border-b bg-gray-50 flex justify-between items-center">
                    <h2 class="font-black text-gray-800 uppercase tracking-tighter">Nueva Sesión de Clase</h2>
                    <button @click="isModalOpen = false" class="text-gray-400 hover:text-red-500 text-2xl font-black">×</button>
                </div>
                <form @submit.prevent="submit" class="p-6 space-y-4">
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase mb-1">Fecha de la Clase</label>
                        <input v-model="form.date" type="date" class="w-full border-gray-200 rounded-xl focus:ring-blue-500" required />
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-500 uppercase mb-1">Tema / Título de la Sesión</label>
                        <input v-model="form.topic" type="text" placeholder="Ej: Introducción a las derivadas..." class="w-full border-gray-200 rounded-xl focus:ring-blue-500" required />
                    </div>
                    <button :disabled="form.processing" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-black shadow-lg shadow-blue-100 hover:bg-blue-700 transition">
                        CREAR Y PASAR LISTA
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
