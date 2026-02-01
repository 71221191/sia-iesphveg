<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';

// --- AGREGA 'Eye' A ESTA LISTA ---
import {
    Plus,
    FileText,
    User,
    Users,
    Upload,
    CheckCircle,
    Eye // <--- Aquí debe estar
} from 'lucide-vue-next';

const props = defineProps({
    project: Object // El controlador ya debe mandar esto (lo hicimos en el paso anterior)
});

const uploadForm = useForm({
    name: '',
    type: 'report',
    file: null
});

const submitDocument = () => {
    uploadForm.post(route('student.thesis.upload-document', props.project.id), {
        onSuccess: () => {
            uploadForm.reset();
            alert('Documento enviado con éxito');
        }
    });
};

</script>

<template>
    <Head title="Mi Tesis" />
    <div class="p-8 max-w-5xl mx-auto">

        <!-- ESCENARIO A: EL ALUMNO NO TIENE PROYECTO AÚN -->
        <div v-if="!project" class="text-center py-20 bg-white rounded-[3rem] shadow-xl border-2 border-dashed border-gray-200">
            <div class="bg-indigo-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-indigo-600">
                <Plus class="w-10 h-10" />
            </div>
            <h2 class="text-2xl font-black text-gray-900 uppercase">¿Listo para empezar tu investigación?</h2>
            <p class="text-gray-500 mt-2 mb-8 max-w-md mx-auto italic">
                Aún no tienes un proyecto de tesis registrado. Registra tu título para que Secretaría te asigne un asesor.
            </p>
            <!-- AQUÍ ESTÁ EL BOTÓN QUE TE FALTABA -->
            <Link :href="route('student.thesis.create')"
                  class="inline-flex items-center px-10 py-4 bg-indigo-600 text-white rounded-2xl font-black shadow-lg hover:bg-indigo-700 transition transform hover:scale-105">
                REGISTRAR PROYECTO DE INVESTIGACIÓN
            </Link>
        </div>

        <!-- ESCENARIO B: EL ALUMNO YA TIENE SU PROYECTO (Importado o Nuevo) -->
        <div v-else class="space-y-6">
            <div class="bg-white p-8 rounded-[3rem] shadow-xl border border-gray-100">
                <div class="flex justify-between items-start mb-6">
                    <span class="px-4 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase border border-green-200">
                        Estado: {{ project.status }}
                    </span>
                    <span v-if="project.is_imported" class="text-[9px] font-bold text-gray-400 uppercase italic">Registro Importado</span>
                </div>

                <h1 class="text-3xl font-black text-gray-900 uppercase leading-tight mb-4">{{ project.title }}</h1>
                <p class="text-indigo-600 font-bold text-sm uppercase tracking-widest">{{ project.research_line }}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10 pt-8 border-t border-gray-50">
                    <!-- Autores -->
                    <div>
                        <h3 class="text-[10px] font-black text-gray-400 uppercase mb-4 tracking-widest">Tesistas</h3>
                        <div v-for="author in project.authors" :key="author.id" class="flex items-center mb-2">
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mr-3 text-gray-500">
                                <User class="w-4 h-4" />
                            </div>
                            <span class="text-sm font-bold text-gray-700 uppercase">{{ author.full_name }}</span>
                        </div>
                    </div>
                    <!-- Asesor -->
                    <div>
                        <h3 class="text-[10px] font-black text-gray-400 uppercase mb-4 tracking-widest">Asesor Designado</h3>
                        <div v-if="project.advisor" class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3 text-blue-600">
                                <CheckCircle class="w-4 h-4" />
                            </div>
                            <span class="text-sm font-black text-gray-900 uppercase">{{ project.advisor.full_name }}</span>
                        </div>
                        <div v-else class="text-sm italic text-gray-400">Pendiente de asignación por Secretaría...</div>
                    </div>
                    <!-- RESULTADO DE SUSTENTACIÓN (AÑADIR ESTO) -->
                    <div v-if="project.defense_act" class="mt-8 p-8 bg-indigo-50 border-2 border-indigo-100 rounded-[2.5rem] shadow-inner">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                            <div>
                                <h3 class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Resultado de Sustentación</h3>
                                <div class="flex items-center">
                                    <GraduationCap class="w-6 h-6 text-indigo-600 mr-2" />
                                    <span class="text-xl font-black text-gray-900 uppercase">Examen de Grado</span>
                                </div>
                                <p class="text-[10px] text-gray-500 mt-2 italic">
                                    Fecha: {{ new Date(project.defense_act.defense_date).toLocaleDateString() }} |
                                    Modalidad: {{ project.defense_act.modality }}
                                </p>
                            </div>

                            <!-- NOTA GIGANTE -->
                            <div class="flex items-center space-x-4">
                                <div class="text-right">
                                    <span class="block text-[10px] font-black text-gray-400 uppercase">Calificación</span>
                                    <span class="text-4xl font-black" :class="project.defense_act.result === 'aprobado' ? 'text-green-600' : 'text-red-600'">
                                        {{ String(project.defense_act.score).padStart(2, '0') }}
                                    </span>
                                </div>

                                <div class="h-12 w-[2px] bg-indigo-200"></div>

                                <div :class="project.defense_act.result === 'aprobado' ? 'bg-green-600' : 'bg-red-600'"
                                    class="px-6 py-3 rounded-2xl text-white font-black uppercase text-xs shadow-lg tracking-widest animate-pulse">
                                    {{ project.defense_act.result }}
                                </div>
                            </div>
                        </div>

                        <!-- Mensaje de felicitación -->
                        <div v-if="project.defense_act.result === 'aprobado'" class="mt-6 p-4 bg-white/50 rounded-2xl border border-green-100 text-center">
                            <p class="text-green-700 text-xs font-bold uppercase tracking-tighter">
                                🎉 ¡Felicidades! Has aprobado tu sustentación. Acércate a Secretaría para el trámite de titulación.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- En el <template> de Index.vue -->
            <div class="bg-gray-900 p-8 rounded-[3rem] shadow-2xl text-white">
                <h2 class="text-xl font-black uppercase mb-6 flex items-center">
                    <Upload class="mr-3 w-6 h-6 text-indigo-400" /> Expediente Digital (Informes y Proyecto)
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- FORMULARIO DE SUBIDA RÁPIDA -->
                    <div class="bg-white/5 p-6 rounded-3xl border border-white/10">
                        <h3 class="text-[10px] font-black uppercase text-indigo-300 mb-4 tracking-widest">Subir nuevo archivo</h3>
                        <form @submit.prevent="submitDocument" class="space-y-4">
                            <input v-model="uploadForm.name" type="text" placeholder="Nombre (Ej: Informe 01)" class="w-full bg-white/10 border-white/20 rounded-xl text-xs text-white" required />
                            <select v-model="uploadForm.type" class="w-full bg-white/10 border-white/20 rounded-xl text-xs text-white">
                                <option value="project" class="text-gray-900">Proyecto de Tesis</option>
                                <option value="report" class="text-gray-900">Informe de Avance</option>
                                <option value="final_draft" class="text-gray-900">Borrador Final</option>
                            </select>
                            <input type="file" @input="uploadForm.file = $event.target.files[0]" accept=".pdf" class="w-full text-[10px]" required />
                            <button :disabled="uploadForm.processing" class="w-full bg-indigo-600 py-3 rounded-xl font-black text-[10px] uppercase hover:bg-indigo-500 transition">
                                {{ uploadForm.processing ? 'Subiendo...' : 'Cargar al Expediente' }}
                            </button>
                        </form>
                    </div>

                    <!-- LISTADO DE DOCUMENTOS SUBIDOS -->
                    <div class="space-y-3 max-h-[300px] overflow-y-auto pr-2">
                        <div v-for="doc in project.documents" :key="doc.id" class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5 hover:bg-white/10 transition">
                            <div class="flex items-center">
                                <FileText class="w-5 h-5 text-indigo-400 mr-3" />
                                <div>
                                    <div class="text-xs font-bold uppercase tracking-tighter">{{ doc.name }}</div>
                                    <div class="text-[8px] text-gray-400 uppercase">{{ doc.type }} | {{ new Date(doc.created_at).toLocaleDateString() }}</div>
                                </div>
                            </div>
                            <a :href="'/storage/' + doc.file_path" target="_blank" class="p-2 hover:text-indigo-400 transition">
                                <Eye class="w-4 h-4" />
                            </a>
                        </div>
                        <div v-if="!project.documents?.length" class="text-center py-10 text-gray-500 text-xs italic">
                            Aún no has cargado documentos al expediente.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
