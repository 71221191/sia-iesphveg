<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3';
import { Check, ArrowLeft, Save } from 'lucide-vue-next';

const props = defineProps({
    section: Object,
    catalog: Array,
    selectedIds: Array
});

const form = useForm({
    competencies: props.selectedIds // Iniciamos con las que ya tenía
});

const submit = () => {
    form.post(route('teacher.sections.set-competencies', props.section.id));
};
</script>

<template>
    <Head title="Configurar Evaluación" />
    <div class="p-8 max-w-4xl mx-auto">
        <Link :href="route('teacher.sections.index')" class="flex items-center text-sm text-gray-500 mb-4 hover:text-blue-600 font-bold uppercase tracking-widest">
            <ArrowLeft class="w-4 h-4 mr-1" /> Volver
        </Link>

        <h1 class="text-3xl font-black text-gray-900 mb-2 uppercase">{{ section.course.name }}</h1>
        <p class="text-gray-500 mb-8 font-medium italic">Seleccione las competencias que evaluará en este curso durante el ciclo.</p>

        <form @submit.prevent="submit" class="space-y-8">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div v-for="comp in catalog" :key="comp.id"
                     class="flex items-start p-6 border-b border-gray-50 hover:bg-blue-50/50 transition cursor-pointer"
                     @click="form.competencies.includes(comp.id) ? form.competencies = form.competencies.filter(id => id !== comp.id) : form.competencies.push(comp.id)">

                    <div class="mr-6 mt-1">
                        <div class="w-6 h-6 border-2 rounded-lg flex items-center justify-center transition"
                             :class="form.competencies.includes(comp.id) ? 'bg-blue-600 border-blue-600' : 'border-gray-300'">
                            <Check v-if="form.competencies.includes(comp.id)" class="w-4 h-4 text-white" />
                        </div>
                    </div>

                    <div>
                        <span class="text-[10px] font-black text-blue-500 uppercase tracking-widest">{{ comp.domain.name }}</span>
                        <div class="flex items-center mt-1">
                            <span class="font-black text-gray-900 mr-2">{{ comp.code }}</span>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ comp.description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button :disabled="form.processing" class="bg-gray-900 text-white px-10 py-4 rounded-2xl font-black shadow-2xl hover:bg-blue-700 transition transform hover:scale-105 flex items-center">
                    <Save class="w-5 h-5 mr-2" />
                    GUARDAR CONFIGURACIÓN
                </button>
            </div>
        </form>
    </div>
</template>
