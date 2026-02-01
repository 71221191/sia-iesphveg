<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';
import { BookMarked, Users, Save, ArrowLeft } from 'lucide-vue-next';

const props = defineProps({
    students: Array
});

const form = useForm({
    title: '',
    research_line: '',
    partner_id: null, // Compañero
});

const submit = () => {
    form.post(route('student.thesis.store'));
};
</script>

<template>
    <Head title="Registrar Proyecto de Tesis" />
    <div class="p-8 max-w-3xl mx-auto">
        <Link :href="route('student.thesis.index')" class="flex items-center text-xs font-black text-gray-400 uppercase mb-4 hover:text-indigo-600 transition">
            <ArrowLeft class="w-4 h-4 mr-1" /> Volver
        </Link>

        <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tighter mb-8">Registrar Proyecto de Investigación</h1>

        <form @submit.prevent="submit" class="space-y-6">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-gray-100 space-y-6">
                <!-- Título -->
                <div>
                    <label class="block text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-2">Título del Proyecto</label>
                    <textarea v-model="form.title" rows="3" class="w-full border-gray-200 rounded-2xl focus:ring-indigo-500 text-sm font-medium" placeholder="Escriba el título completo de su investigación..."></textarea>
                    <div v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</div>
                </div>

                <!-- Línea de Investigación -->
                <div>
                    <label class="block text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-2">Línea de Investigación</label>
                    <select v-model="form.research_line" class="w-full border-gray-200 rounded-2xl focus:ring-indigo-500 text-sm">
                        <option value="">Seleccione una línea...</option>
                        <option value="Innovación Pedagógica">Innovación Pedagógica</option>
                        <option value="Gestión Educativa">Gestión Educativa</option>
                        <option value="Tecnologías de la Información">Tecnologías de la Información</option>
                        <option value="Didáctica de la Especialidad">Didáctica de la Especialidad</option>
                    </select>
                </div>

                <!-- Compañero (Opcional) -->
                <div class="pt-4 border-t border-gray-50">
                    <div class="flex items-center mb-4">
                        <Users class="w-4 h-4 text-gray-400 mr-2" />
                        <label class="text-xs font-bold text-gray-700 uppercase">¿Trabajo en Pareja? (Opcional)</label>
                    </div>
                    <select v-model="form.partner_id" class="w-full border-gray-100 bg-gray-50 rounded-2xl text-xs">
                        <option :value="null">Proyecto Individual</option>
                        <option v-for="s in students" :key="s.id" :value="s.id">
                            {{ s.last_name_p }} {{ s.names }}
                        </option>
                    </select>
                    <p class="mt-2 text-[10px] text-gray-400 italic leading-tight">
                        * Si selecciona un compañero, el proyecto aparecerá automáticamente en el portal de ambos.
                    </p>
                </div>
            </div>

            <button :disabled="form.processing" class="w-full bg-gray-900 text-white py-4 rounded-2xl font-black shadow-2xl shadow-gray-200 hover:bg-indigo-600 transition transform hover:scale-[1.02] flex items-center justify-center">
                <Save class="w-5 h-5 mr-2" />
                REGISTRAR PROYECTO OFICIAL
            </button>
        </form>
    </div>
</template>
