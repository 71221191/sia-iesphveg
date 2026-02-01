<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';
import { FileText, Upload, Trash2, CheckCircle, Clock, AlertCircle, ArrowLeft } from 'lucide-vue-next';

const props = defineProps({
    section: Object,
    files: Array
});

const form = useForm({
    type: 'syllabus',
    name: '',
    file: null
});

const submit = () => {
    form.post(route('teacher.portfolio.store', props.section.id), {
        onSuccess: () => form.reset(),
    });
};

const getStatusStyle = (status) => {
    if (status === 'approved') return 'bg-green-100 text-green-700 border-green-200';
    if (status === 'observed') return 'bg-red-100 text-red-700 border-red-200';
    return 'bg-yellow-100 text-yellow-700 border-yellow-200';
};
</script>

<template>
    <Head title="Portafolio Docente" />
    <div class="p-8 max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <Link :href="route('teacher.sections.index')" class="text-sm font-bold text-gray-500 uppercase flex items-center mb-2">
                <ArrowLeft class="w-4 h-4 mr-1" /> Volver a mis cursos
            </Link>
            <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">{{ section.course.name }}</h1>
            <p class="text-gray-500 font-mono text-sm uppercase">Gestión de Portafolio Digital | Sección {{ section.name }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Formulario de Subida -->
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 sticky top-8">
                    <h2 class="font-black text-gray-800 mb-6 text-xs uppercase tracking-widest flex items-center">
                        <Upload class="mr-2 w-4 h-4 text-blue-600" /> Cargar Documento
                    </h2>
                    
                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Tipo de Archivo</label>
                            <select v-model="form.type" class="w-full border-gray-100 rounded-xl focus:ring-blue-500 text-sm">
                                <option value="syllabus">SÍLABO</option>
                                <option value="session">SESIÓN DE APRENDIZAJE</option>
                                <option value="instrument">INSTRUMENTO DE EVALUACIÓN</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Nombre del Archivo</label>
                            <input v-model="form.name" type="text" placeholder="Ej: Sílabo Matemática I..." class="w-full border-gray-100 rounded-xl text-sm" />
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Archivo (PDF max 2MB)</label>
                            <input type="file" @input="form.file = $event.target.files[0]" accept=".pdf" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700" />
                        </div>

                        <button :disabled="form.processing" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-black shadow-lg shadow-blue-100 hover:bg-blue-700 transition">
                            {{ form.processing ? 'SUBIENDO...' : 'SUBIR AL PORTAFOLIO' }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Listado de Archivos -->
            <div class="lg:col-span-2 space-y-4">
                <div v-for="file in files" :key="file.id" 
                     class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between hover:shadow-md transition">
                    <div class="flex items-center space-x-4">
                        <div class="bg-red-50 p-3 rounded-xl text-red-500">
                            <FileText class="w-6 h-6" />
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm uppercase leading-none">{{ file.name }}</h3>
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">{{ file.type }}</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Badge de Estado -->
                        <span :class="getStatusStyle(file.status)" class="px-3 py-1 rounded-full text-[9px] font-black uppercase border">
                            {{ file.status }}
                        </span>

                        <!-- Acciones -->
                        <div class="flex space-x-2">
                            <a :href="'/storage/' + file.file_path" target="_blank" class="p-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
                                <Clock class="w-4 h-4" v-if="file.status === 'pending'" />
                                <CheckCircle class="w-4 h-4" v-else />
                            </a>
                            <button v-if="file.status !== 'approved'" @click="$inertia.delete(route('teacher.portfolio.destroy', file.id))" 
                                    class="p-2 bg-gray-100 text-gray-400 rounded-lg hover:bg-red-50 hover:text-red-600 transition">
                                <Trash2 class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                </div>

                <div v-if="files.length === 0" class="p-20 text-center text-gray-400 italic">
                    No has subido ningún documento al portafolio de esta sección.
                </div>
            </div>
        </div>
    </div>
</template>