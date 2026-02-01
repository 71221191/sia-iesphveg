<script setup>
import { ref } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import { School, Plus, Edit, MapPin } from 'lucide-vue-next';

const props = defineProps({
    centers: Array,
    ubigeos: Array
});

const isEditing = ref(false);
const selectedId = ref(null);

const form = useForm({
    name: '',
    modular_code: '',
    level: 'secundaria',
    director_name: '',
    address: '',
    ubigeo_id: '',
});

const submit = () => {
    if (isEditing.value) {
        form.put(route('admin.centros-practica.update', selectedId.value), {
            onSuccess: () => resetForm()
        });
    } else {
        form.post(route('admin.centros-practica.store'), {
            onSuccess: () => resetForm()
        });
    }
};

const edit = (center) => {
    isEditing.value = true;
    selectedId.value = center.id;
    form.name = center.name;
    form.modular_code = center.modular_code;
    form.level = center.level;
    form.director_name = center.director_name;
    form.address = center.address;
    form.ubigeo_id = center.ubigeo_id;
};

const resetForm = () => {
    isEditing.value = false;
    selectedId.value = null;
    form.reset();
};
</script>

<template>
    <Head title="Centros de Práctica" />
    <div class="p-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-black text-gray-900 mb-8 uppercase flex items-center tracking-tighter">
                <School class="mr-3 w-8 h-8 text-indigo-600" />
                Directorio de Instituciones Educativas (I.E.)
            </h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- FORMULARIO -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 sticky top-8">
                        <h2 class="font-bold text-gray-800 mb-6 uppercase text-sm tracking-widest">
                            {{ isEditing ? 'Editar Institución' : 'Registrar Nueva I.E.' }}
                        </h2>
                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Nombre de la I.E.</label>
                                <input v-model="form.name" type="text" class="w-full border-gray-200 rounded-xl text-sm" placeholder="Ej: San Ramón" />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Cód. Modular</label>
                                    <input v-model="form.modular_code" type="text" class="w-full border-gray-200 rounded-xl text-sm" placeholder="7 dígitos" />
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Nivel</label>
                                    <select v-model="form.level" class="w-full border-gray-200 rounded-xl text-sm">
                                        <option value="inicial">INICIAL</option>
                                        <option value="primaria">PRIMARIA</option>
                                        <option value="secundaria">SECUNDARIA</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Distrito (Ubigeo)</label>
                                <select v-model="form.ubigeo_id" class="w-full border-gray-200 rounded-xl text-sm">
                                    <option v-for="u in ubigeos" :key="u.id" :value="u.id">{{ u.district }} ({{ u.province }})</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Director(a)</label>
                                <input v-model="form.director_name" type="text" class="w-full border-gray-200 rounded-xl text-sm" />
                            </div>
                            <button class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold text-xs uppercase shadow-lg shadow-indigo-100">
                                {{ isEditing ? 'GUARDAR CAMBIOS' : 'REGISTRAR COLEGIO' }}
                            </button>
                            <button v-if="isEditing" @click="resetForm" type="button" class="w-full text-gray-400 text-[10px] font-bold uppercase">Cancelar</button>
                        </form>
                    </div>
                </div>

                <!-- LISTADO -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-900 text-white text-[10px] uppercase font-black tracking-widest">
                                    <th class="p-4">Institución Educativa</th>
                                    <th class="p-4 text-center">Nivel</th>
                                    <th class="p-4 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr v-for="center in centers" :key="center.id" class="hover:bg-indigo-50/30 transition">
                                    <td class="p-4">
                                        <div class="font-bold text-gray-900 uppercase text-xs">{{ center.name }}</div>
                                        <div class="text-[10px] text-gray-400 font-mono">CÓD: {{ center.modular_code }} | {{ center.ubigeo.district }}</div>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-[9px] font-black uppercase">{{ center.level }}</span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <button @click="edit(center)" class="text-indigo-600 hover:bg-indigo-50 p-2 rounded-lg transition">
                                            <Edit class="w-4 h-4" />
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>