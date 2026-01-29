<script setup lang="ts">
import { ref, computed, watch } from 'vue';

import { useForm, Head } from '@inertiajs/vue3';
import {
    CheckCircle2,
    ChevronRight,
    ChevronLeft,
    Save,
    User,
    MapPin,
    HeartPulse,
    Wallet,
    AlertCircle
} from 'lucide-vue-next';
import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

// Utilidad para clases dinámicas (estilo shadcn)
function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}

// 1. PROPS (Lo que recibimos del Controlador Laravel)
const props = defineProps<{
    // Podemos crear una interfaz para initialData si es muy grande,
    // o simplemente dar una pista a TypeScript para las propiedades conflictivas
    initialData: {
        marital_status_id: number | null;
        native_language_id: number | null;
        ethnicity_id: number | null;
        phone: string | null;
        email: string | null;
        address: string | null;
        ubigeo_residence_id: number | null;
        has_disability: boolean;
        disability_type_id: number | null;
        conadis_number: string | null;
        work_status: boolean;
        work_type: string | null;
        has_children: boolean;
        children_count: number | null;
        scholarship_type_id: number | null;
        // Y otras propiedades que inicialices en formData en el controlador y uses aquí:
        names: string;
        last_name_p: string;
        last_name_m: string;
        dni: string;
        birth_date: string;
        gender: string;
    };
    catalogs: {
        identity_types: any[];
        civil_statuses: any[];
        languages: any[];
        ethnicities: any[];
        disabilities: any[];
        scholarships: any[];
        ubigeos: any[];
    };
    periodo: string;
}>();

// 2. ESTADO DEL WIZARD
const currentStep = ref(1);
const totalSteps = 4;

const steps = [
    { id: 1, title: 'Identidad', icon: User },
    { id: 2, title: 'Ubicación', icon: MapPin },
    { id: 3, title: 'Salud', icon: HeartPulse },
    { id: 4, title: 'Economía', icon: Wallet },
];

// 3. FORMULARIO INERTIA (Se inicializa con los datos del Excel
const form = useForm({
    ...props.initialData, // Hydration (Pre-llenado)
    confirmacion_jurada: false
});


watch(() => form.has_children, (newValue) => {
    if (newValue && (form.children_count === null || form.children_count === 0)) {
        form.children_count = 1; // Si tiene hijos y la cantidad es 0 o nula, establecer a 1
    } else if (!newValue) {
        form.children_count = null; // <--- ¡CAMBIAR 0 por NULL aquí!
    }
}, { immediate: true }); // 'immediate: true' para que se ejecute la primera vez al cargar
// ---------------------------------------------------

// 4. FUNCIONES DE NAVEGACIÓN
const nextStep = () => {
    if (currentStep.value < totalSteps) {
        currentStep.value++;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

const prevStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

const submit = () => {
    form.post('/ficha-socioeconomica', {
        preserveScroll: true,
        onSuccess: () => {
            // Opcional: Mostrar toast de éxito
        }
    });
};

// 5. LÓGICA DE UBIGEO (Buscador simple en cliente)
const searchUbigeo = ref('');
const ubigeosFiltrados = computed(() => {
    if (!searchUbigeo.value) return props.catalogs.ubigeos.slice(0, 50); // Mostrar primeros 50 para no laggear
    return props.catalogs.ubigeos.filter(u =>
        u.label.toLowerCase().includes(searchUbigeo.value.toLowerCase())
    ).slice(0, 50);
});

</script>

<template>
    <Head title="Ficha Socioeconómica" />

    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8 font-sans">
        <div class="max-w-4xl mx-auto">

            <!-- ENCABEZADO -->
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Ficha Socioeconómica</h1>
                <p class="mt-2 text-gray-600">
                    Actualización de Datos para Matrícula <span class="font-bold text-blue-600">{{ periodo }}</span>
                </p>
            </div>

            <!-- STEPPER (BARRA DE PROGRESO) -->
            <div class="mb-8">
                <div class="flex items-center justify-between relative">
                    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 -z-10 rounded-full"></div>
                    <div
                        class="absolute left-0 top-1/2 transform -translate-y-1/2 h-1 bg-blue-600 -z-10 rounded-full transition-all duration-500"
                        :style="{ width: `${((currentStep - 1) / (totalSteps - 1)) * 100}%` }"
                    ></div>

                    <div v-for="step in steps" :key="step.id" class="flex flex-col items-center">
                        <div
                            :class="cn(
                                'w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 border-4',
                                currentStep >= step.id
                                    ? 'bg-blue-600 border-blue-100 text-white shadow-lg shadow-blue-200'
                                    : 'bg-white border-gray-200 text-gray-400'
                            )"
                        >
                            <component :is="step.icon" class="w-5 h-5" />
                        </div>
                        <span
                            :class="cn(
                                'mt-2 text-xs font-medium transition-colors duration-300 hidden sm:block',
                                currentStep >= step.id ? 'text-blue-700' : 'text-gray-400'
                            )"
                        >
                            {{ step.title }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- BLOQUE GENERAL DE ERRORES DE VALIDACIÓN (¡AÑADE ESTO AQUÍ!) -->
            <div v-if="Object.keys(form.errors).length > 0" class="bg-red-50 border border-red-300 text-red-800 px-6 py-4 rounded-lg mb-8 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <AlertCircle class="w-5 h-5 shrink-0" />
                    <h3 class="font-bold text-lg">Por favor, corrige los siguientes errores:</h3>
                </div>
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    <li v-for="(error, field) in form.errors" :key="field">
                        {{ error }}
                    </li>
                </ul>
            </div>

            <!-- FORMULARIO CARD -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <form @submit.prevent="submit" class="p-6 sm:p-10">

                    <!-- PASO 1: IDENTIDAD -->
                    <div v-show="currentStep === 1" class="space-y-6 animate-in fade-in slide-in-from-right-4 duration-500">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-6">Datos de Identidad</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Campos Bloqueados (Vienen del Excel) -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">DNI / Documento</label>
                                <input type="text" :value="form.dni" disabled class="block w-full rounded-lg border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed px-4 py-2.5 border shadow-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Nombres y Apellidos</label>
                                <input type="text" :value="`${form.last_name_p} ${form.last_name_m}, ${form.names}`" disabled class="block w-full rounded-lg border-gray-200 bg-gray-50 text-gray-500 cursor-not-allowed px-4 py-2.5 border shadow-sm">
                            </div>

                            <!-- Campos Editables -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Estado Civil <span class="text-red-500">*</span></label>
                                <select v-model="form.marital_status_id" class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 shadow-sm transition-colors">
                                    <option value="">Seleccione...</option>
                                    <option v-for="item in catalogs.civil_statuses" :key="item.id" :value="item.id">{{ item.name }}</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Lengua Materna <span class="text-red-500">*</span></label>
                                <select v-model="form.native_language_id" class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 shadow-sm transition-colors">
                                    <option v-for="item in catalogs.languages" :key="item.id" :value="item.id">{{ item.name }}</option>
                                </select>
                            </div>

                            <div class="md:col-span-2 space-y-2">
                                <label class="text-sm font-medium text-gray-700">Autoidentificación Étnica <span class="text-red-500">*</span></label>
                                <select v-model="form.ethnicity_id" class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 shadow-sm transition-colors">
                                    <option v-for="item in catalogs.ethnicities" :key="item.id" :value="item.id">{{ item.name }}</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">¿Cómo te sientes o consideras tú según tus antepasados y costumbres?</p>
                            </div>
                        </div>
                    </div>

                    <!-- PASO 2: UBICACIÓN -->
                    <div v-show="currentStep === 2" class="space-y-6 animate-in fade-in slide-in-from-right-4 duration-500">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-6">Ubicación y Contacto</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Celular <span class="text-red-500">*</span></label>
                                <input v-model="form.phone" type="tel" class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 shadow-sm">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Correo Electrónico</label>
                                <input v-model="form.email" type="email" class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 shadow-sm">
                            </div>

                            <div class="md:col-span-2 space-y-2">
                                <label class="text-sm font-medium text-gray-700">Dirección Actual <span class="text-red-500">*</span></label>
                                <input v-model="form.address" type="text" placeholder="Jr. Los Pinos 123..." class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-4 py-2.5 shadow-sm">
                            </div>

                            <!-- Selector de Ubigeo con Buscador Simple -->
                            <div class="md:col-span-2 space-y-2">
                                <label class="text-sm font-medium text-gray-700">Distrito de Residencia (Cajamarca) <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input
                                        type="text"
                                        v-model="searchUbigeo"
                                        placeholder="🔍 Escribe para buscar tu distrito..."
                                        class="block w-full rounded-t-lg border-gray-300 border-b-0 focus:border-blue-500 focus:ring-0 px-4 py-2 text-sm bg-gray-50"
                                    >
                                    <select v-model="form.ubigeo_residence_id" size="5" class="block w-full rounded-b-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 px-2 py-2 text-sm shadow-sm">
                                        <option v-for="ubigeo in ubigeosFiltrados" :key="ubigeo.id" :value="ubigeo.id">
                                            {{ ubigeo.label }}
                                        </option>
                                    </select>
                                </div>
                                <p class="text-xs text-gray-500">Selecciona tu distrito de la lista.</p>
                            </div>
                        </div>
                    </div>

                    <!-- PASO 3: SALUD Y DISCAPACIDAD -->
                    <div v-show="currentStep === 3" class="space-y-6 animate-in fade-in slide-in-from-right-4 duration-500">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-6">Salud e Inclusión</h2>

                        <!-- Card de Pregunta SI/NO -->
                        <div class="space-y-3">
                            <label class="text-sm font-medium text-gray-700">¿Presentas alguna condición de discapacidad?</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label
                                    :class="cn(
                                        'cursor-pointer border rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition-all',
                                        form.has_disability ? 'border-blue-500 bg-blue-50 text-blue-700 ring-2 ring-blue-500' : 'border-gray-200 hover:border-gray-300'
                                    )"
                                >
                                    <input type="radio" :value="true" v-model="form.has_disability" class="sr-only">
                                    <span class="font-bold">SÍ</span>
                                </label>
                                <label
                                    :class="cn(
                                        'cursor-pointer border rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition-all',
                                        !form.has_disability ? 'border-gray-500 bg-gray-50 text-gray-700 ring-2 ring-gray-500' : 'border-gray-200 hover:border-gray-300'
                                    )"
                                >
                                    <input type="radio" :value="false" v-model="form.has_disability" class="sr-only">
                                    <span class="font-bold">NO</span>
                                </label>
                            </div>
                        </div>

                        <!-- Condicionales -->
                        <div v-if="form.has_disability" class="p-4 bg-blue-50 rounded-lg border border-blue-100 space-y-4 animate-in fade-in zoom-in-95">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Tipo de Discapacidad</label>
                                <select v-model="form.disability_type_id" class="block w-full rounded-lg border-gray-300 px-4 py-2.5">
                                    <option v-for="item in catalogs.disabilities" :key="item.id" :value="item.id">{{ item.name }}</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Número de Carné CONADIS</label>
                                <input v-model="form.conadis_number" type="text" class="block w-full rounded-lg border-gray-300 px-4 py-2.5">
                            </div>
                        </div>
                    </div>

                    <!-- PASO 4: SOCIOECONÓMICO -->
                    <div v-show="currentStep === 4" class="space-y-6 animate-in fade-in slide-in-from-right-4 duration-500">
                        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-6">Situación Socioeconómica</h2>

                        <!-- Trabajo -->
                        <div class="space-y-3">
                            <label class="text-sm font-medium text-gray-700">¿Trabajas actualmente?</label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" :value="true" v-model="form.work_status" class="form-radio text-blue-600 h-5 w-5">
                                    <span class="ml-2 text-gray-700">Sí</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" :value="false" v-model="form.work_status" class="form-radio text-blue-600 h-5 w-5">
                                    <span class="ml-2 text-gray-700">No</span>
                                </label>
                            </div>
                            <div v-if="form.work_status" class="mt-2">
                                <input v-model="form.work_type" type="text" placeholder="¿En qué trabajas? (Ej: Comerciante)" class="block w-full rounded-lg border-gray-300 px-4 py-2.5">
                            </div>
                        </div>

                        <!-- Carga Familiar -->
                        <div class="space-y-3 pt-4 border-t border-gray-100">
                            <label class="text-sm font-medium text-gray-700">¿Tienes hijos?</label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" :value="true" v-model="form.has_children" class="form-radio text-blue-600 h-5 w-5">
                                    <span class="ml-2 text-gray-700">Sí</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" :value="false" v-model="form.has_children" class="form-radio text-blue-600 h-5 w-5">
                                    <span class="ml-2 text-gray-700">No</span>
                                </label>
                            </div>
                            <div v-if="form.has_children" class="mt-2 w-32">
                                <label class="text-xs text-gray-500">Cantidad</label>
                                <!-- ¡Asegúrate de que este input siempre tenga un valor >= 1 si has_children es true! -->
                                <input v-model="form.children_count" type="number" min="1" class="block w-full rounded-lg border-gray-300 px-4 py-2.5">
                                <!-- Puedes añadir el mensaje de error específico aquí también -->
                                <div v-if="form.errors.children_count" class="text-sm text-red-600 mt-1">
                                    {{ form.errors.children_count }}
                                </div>
                            </div>
                        </div>

                        <!-- Becas -->
                        <div class="space-y-3 pt-4 border-t border-gray-100">
                            <label class="text-sm font-medium text-gray-700">¿Eres beneficiario de alguna Beca?</label>
                            <select v-model="form.scholarship_type_id" class="block w-full rounded-lg border-gray-300 px-4 py-2.5">
                                <option v-for="item in catalogs.scholarships" :key="item.id" :value="item.id">{{ item.name }}</option>
                            </select>
                        </div>

                        <!-- Declaración Jurada -->
                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 mt-6 flex items-start gap-3">
                            <AlertCircle class="w-5 h-5 text-yellow-600 mt-0.5 shrink-0" />
                            <div class="text-sm text-yellow-800">
                                <p class="font-bold">Declaración Jurada</p>
                                <label class="flex items-center gap-2 mt-2 cursor-pointer">
                                    <input type="checkbox" v-model="form.confirmacion_jurada" class="rounded border-yellow-400 text-yellow-700 focus:ring-yellow-500 w-5 h-5">
                                    <span>Declaro bajo juramento que toda la información registrada es verdadera y acepto el reglamento de la institución.</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- FOOTER BOTONES -->
                    <div class="mt-10 flex justify-between items-center pt-6 border-t border-gray-100">
                        <button
                            type="button"
                            @click="prevStep"
                            :class="cn('flex items-center px-6 py-3 rounded-xl font-medium transition-all', currentStep === 1 ? 'opacity-0 pointer-events-none' : 'text-gray-600 hover:bg-gray-100')"
                        >
                            <ChevronLeft class="w-5 h-5 mr-2" />
                            Atrás
                        </button>

                        <button
                            v-if="currentStep < totalSteps"
                            type="button"
                            @click="nextStep"
                            class="flex items-center bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-200 transition-all transform hover:scale-105"
                        >
                            Siguiente
                            <ChevronRight class="w-5 h-5 ml-2" />
                        </button>

                        <button
                            v-else
                            type="submit"
                            :disabled="form.processing || !form.confirmacion_jurada"
                            :class="cn(
                                'flex items-center px-8 py-3 rounded-xl font-bold shadow-lg transition-all transform hover:scale-105',
                                form.processing || !form.confirmacion_jurada
                                    ? 'bg-gray-300 text-gray-500 cursor-not-allowed shadow-none'
                                    : 'bg-green-600 hover:bg-green-700 text-white shadow-green-200'
                            )"
                        >
                            <Save class="w-5 h-5 mr-2" />
                            {{ form.processing ? 'Guardando...' : 'Finalizar y Guardar' }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>
