<script setup>
import { ref } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import { LayoutGrid, Plus, BookOpen, Hash } from 'lucide-vue-next';
const editingCompetency = ref(null);

const isDomainModalOpen = ref(false);

const domainForm = useForm({
    name: '',
    description: ''
});

const submitDomain = () => {
    domainForm.post(route('admin.domains.store'), {
        onSuccess: () => domainForm.reset(),
    });
};

const props = defineProps({
    competencies: Array,
    domains: Array
});

const form = useForm({
    domain_id: '',
    code: '',
    description: '',
});

const editCompetency = (comp) => {
    editingCompetency.value = comp;
    form.domain_id = comp.domain_id;
    form.code = comp.code;
    form.description = comp.description;
};

const cancelEdit = () => {
    editingCompetency.value = null;
    form.reset();
};

const submit = () => {
    if (editingCompetency.value) {
        // Si estamos editando, usamos PUT a la ruta de update
        form.put(route('admin.competencies.update', editingCompetency.value.id), {
            onSuccess: () => cancelEdit(),
        });
    } else {
        // Si no, es un registro nuevo
        form.post(route('admin.competencies.store'), {
            onSuccess: () => form.reset(),
        });
    }
};

</script>

<template>
    <Head title="Catálogo de Competencias" />

    <div class="p-8 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-3xl font-black text-gray-900 mb-8 uppercase tracking-tight flex items-center">
                <BookOpen class="mr-3 w-8 h-8 text-blue-600" />
                Catálogo Nacional de Competencias
            </h1>

            <!-- Botón para abrir gestión de dominios -->
            <button @click="isDomainModalOpen = true"
                    class="mb-6 text-xs font-bold text-blue-600 underline hover:text-blue-800">
                ⚙️ Gestionar Dominios del DCBN
            </button>

            <!-- ... (resto de tu código anterior) ... -->

            <!-- MODAL DE GESTIÓN DE DOMINIOS -->
            <div v-if="isDomainModalOpen" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                <div class="bg-white rounded-3xl w-full max-w-2xl shadow-2xl overflow-hidden">
                    <div class="p-6 border-b flex justify-between items-center bg-gray-50">
                        <h2 class="font-black text-gray-800 uppercase">Gestión de Dominios Académicos</h2>
                        <button @click="isDomainModalOpen = false" class="text-gray-400 hover:text-red-500 font-black text-2xl">×</button>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Formulario de Dominio -->
                        <div>
                            <h3 class="text-xs font-black text-gray-400 uppercase mb-4 tracking-widest">Añadir Dominio</h3>
                            <form @submit.prevent="submitDomain" class="space-y-4">
                                <input v-model="domainForm.name" type="text" placeholder="Nombre del dominio..." class="w-full border-gray-200 rounded-xl" />
                                <textarea v-model="domainForm.description" placeholder="Descripción breve..." class="w-full border-gray-200 rounded-xl text-sm"></textarea>
                                <button class="w-full bg-blue-600 text-white py-2 rounded-xl font-bold text-xs">GUARDAR DOMINIO</button>
                            </form>
                        </div>

                        <!-- Lista de Dominios Existentes -->
                        <div class="max-h-[300px] overflow-y-auto">
                            <h3 class="text-xs font-black text-gray-400 uppercase mb-4 tracking-widest">Dominios Actuales</h3>
                            <div v-for="domain in domains" :key="domain.id" class="p-3 bg-gray-50 rounded-xl mb-2 flex justify-between items-center">
                                <span class="text-xs font-bold text-gray-700 leading-tight">{{ domain.name }}</span>
                                <!-- Botón eliminar dominio opcional -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- FORMULARIO DE REGISTRO -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-8">
                        <h2 class="font-bold text-gray-800 mb-6 flex items-center uppercase text-sm tracking-wider">
                            <!-- Si estamos editando, mostramos icono de lápiz y color naranja -->
                            <component :is="editingCompetency ? 'Edit' : 'Plus'"
                                    :class="['mr-2 w-4 h-4', editingCompetency ? 'text-orange-500' : 'text-blue-500']" />
                            {{ editingCompetency ? 'Editando Competencia' : 'Nueva Competencia' }}
                        </h2>

                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
                                <label class="block text-xs font-black text-gray-500 uppercase mb-1">Dominio MINEDU</label>
                                <select v-model="form.domain_id" class="w-full border-gray-200 rounded-xl focus:ring-blue-500">
                                    <option value="">Seleccione un dominio...</option>
                                    <option v-for="domain in domains" :key="domain.id" :value="domain.id">
                                        {{ domain.name }}
                                    </option>
                                </select>
                                <div v-if="form.errors.domain_id" class="text-red-500 text-[10px] mt-1 font-bold">{{ form.errors.domain_id }}</div>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-500 uppercase mb-1">Código (Ej: C1)</label>
                                <input v-model="form.code" type="text" placeholder="C1, C2..." class="w-full border-gray-200 rounded-xl focus:ring-blue-500" />
                                <div v-if="form.errors.code" class="text-red-500 text-[10px] mt-1 font-bold">{{ form.errors.code }}</div>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-500 uppercase mb-1">Descripción de la Competencia</label>
                                <textarea v-model="form.description" rows="4" class="w-full border-gray-200 rounded-xl focus:ring-blue-500" placeholder="Describa la competencia según el DCBN..."></textarea>
                                <div v-if="form.errors.description" class="text-red-500 text-[10px] mt-1 font-bold">{{ form.errors.description }}</div>
                            </div>

                            <div class="space-y-2">
                                <button :disabled="form.processing"
                                        class="w-full py-3 rounded-xl font-bold transition shadow-lg flex items-center justify-center"
                                        :class="editingCompetency ? 'bg-orange-600 hover:bg-orange-700 text-white shadow-orange-100' : 'bg-gray-900 hover:bg-blue-600 text-white shadow-gray-200'">
                                    {{ editingCompetency ? 'GUARDAR CAMBIOS' : 'REGISTRAR COMPETENCIA' }}
                                </button>

                                <!-- Botón para salir del modo edición sin guardar -->
                                <button v-if="editingCompetency"
                                        @click="cancelEdit"
                                        type="button"
                                        class="w-full bg-white text-gray-500 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border border-gray-100 hover:bg-gray-50">
                                    Cancelar Edición
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- LISTADO DE COMPETENCIAS -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="p-4 text-[10px] font-black uppercase text-gray-400 tracking-widest w-20">Código</th>
                                    <th class="p-4 text-[10px] font-black uppercase text-gray-400 tracking-widest">Dominio / Descripción</th>
                                    <th class="p-4 w-20"></th> <!-- Columna para el botón -->
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr v-for="comp in competencies" :key="comp.id" class="hover:bg-gray-50/50 transition">
                                    <td class="p-4 align-top">
                                        <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg font-black text-xs">
                                            {{ comp.code }}
                                        </span>
                                    </td>
                                    <td class="p-4">
                                        <div class="text-[10px] font-bold text-blue-500 uppercase mb-1">
                                            {{ comp.domain.name }}
                                        </div>
                                        <p class="text-sm text-gray-600 leading-relaxed">
                                            {{ comp.description }}
                                        </p>
                                    </td>
                                    <td class="p-4 text-right">
                                        <button @click="editCompetency(comp)"
                                                class="text-blue-600 hover:text-blue-800 font-bold text-[10px] uppercase tracking-tighter border border-blue-200 px-2 py-1 rounded hover:bg-blue-50 transition">
                                            Editar
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="competencies.length === 0">
                                    <td colspan="2" class="p-12 text-center text-gray-400 italic">
                                        No hay competencias registradas en el catálogo.
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
