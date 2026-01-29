<script setup>
import { ref, watch } from 'vue';
import { router, Head, Link } from '@inertiajs/vue3';

const props = defineProps({ students: Object, filters: Object });
const search = ref(props.filters.search);

watch(search, (value) => {
    router.get('/admin/estudiantes', { search: value }, {
        preserveState: true,
        replace: true
    });
});
</script>

<template>
    <Head title="Estudiantes" />

    <div class="p-8 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Consulta de Estudiantes e Historial</h1>

            <!-- Buscador -->
            <div class="mb-6">
                <input v-model="search" type="text" placeholder="Buscar por DNI o Apellidos..."
                    class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Tabla -->
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="p-4">DNI</th>
                            <th class="p-4">Apellidos y Nombres</th>
                            <th class="p-4 text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="student in students.data" :key="student.id" class="hover:bg-gray-50">
                            <td class="p-4 font-mono">{{ student.dni }}</td>
                            <td class="p-4">{{ student.last_name_p }} {{ student.last_name_m }}, {{ student.names }}</td>
                            <td class="p-4 text-center">
                                <!-- CAMBIO AQUÍ: Ruta manual en lugar de usar route() -->
                                <Link :href="'/admin/estudiantes/' + student.id"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-700">
                                    VER NOTAS
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="mt-6 flex justify-center gap-2">
                <Link v-for="link in students.links" :key="link.label"
                    :href="link.url || '#'"
                    v-html="link.label"
                    class="px-4 py-2 border rounded"
                    :class="{'bg-blue-600 text-white': link.active, 'text-gray-400': !link.url}"
                />
            </div>
        </div>
    </div>
</template>
