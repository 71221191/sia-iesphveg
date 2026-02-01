<script setup>
// --- 1. IMPORTAR DESDE VUE (ESTA ES LA LÍNEA QUE FALTA) ---
import { ref, watch } from 'vue';

// 2. IMPORTAR DESDE INERTIA
import { Head, Link, router } from '@inertiajs/vue3';

// 3. IMPORTAR ICONOS Y COMPONENTES
import Pagination from '@/components/Pagination.vue';
import { FileText, User, Users, Search, ChevronRight } from 'lucide-vue-next';

const props = defineProps({
    projects: Object,
    filters: Object // Para que el buscador no se borre al refrescar
});

// --- AQUÍ ES DONDE DABA EL ERROR PORQUE 'ref' NO EXISTÍA ---
const search = ref(props.filters?.search || '');

// Lógica del buscador
watch(search, (value) => {
    router.get(route('admin.thesis.index'), { search: value }, {
        preserveState: true,
        replace: true
    });
});

const getStatusBadge = (status) => {
    const styles = {
        'registered': 'bg-blue-100 text-blue-700',
        'approved': 'bg-green-100 text-green-700',
        'defended': 'bg-purple-100 text-purple-700'
    };
    return styles[status] || 'bg-gray-100 text-gray-700';
};
</script>

<template>
    <Head title="Gestión de Tesis" />
    <div class="p-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-black text-gray-900 mb-8 uppercase tracking-tighter">Expedientes de Grados y Títulos</h1>
            <div class="mb-6 flex justify-between items-center">
                <div class="relative w-full max-w-md">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <Search class="w-5 h-5 text-gray-400" />
                    </span>
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Buscar por título o apellido del alumno..."
                        class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-2xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm shadow-sm"
                    />
                </div>
            </div>

            <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-900 text-white text-[10px] uppercase font-black tracking-widest">
                            <th class="p-4">Título del Proyecto</th>
                            <th class="p-4">Autores</th>
                            <th class="p-4 text-center">Estado</th>
                            <th class="p-4">Asesor</th>
                            <th class="p-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-xs">
                        <tr v-for="project in projects.data" :key="project.id" class="hover:bg-gray-50 transition">
                            <td class="p-4 max-w-xs">
                                <div class="font-bold text-gray-900 uppercase truncate" :title="project.title">{{ project.title }}</div>
                                <div class="text-[9px] text-gray-400 mt-1 uppercase">{{ project.research_line }}</div>
                            </td>
                            <td class="p-4 text-gray-600">
                                <div v-for="author in project.authors" :key="author.id" class="flex items-center mb-1 uppercase font-medium text-[10px]">
                                    <User class="w-3 h-3 mr-1 opacity-40" /> {{ author.last_name_p }}
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <span :class="getStatusBadge(project.status)" class="px-3 py-1 rounded-full font-black text-[9px] uppercase border">
                                    {{ project.status }}
                                </span>
                            </td>
                            <td class="p-4 italic text-gray-500">
                                {{ project.advisor ? project.advisor.last_name_p : 'Pendiente' }}
                            </td>
                            <td class="p-4 text-right">
                                <Link :href="route('admin.thesis.show', project.id)" class="text-indigo-600 font-bold hover:underline">
                                    GESTIONAR →
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :links="projects.links" />
            </div>
        </div>
    </div>
</template>
