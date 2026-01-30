<script setup>
import { ref, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';

const props = defineProps({
    payments: Object,
    currentStatus: String
});

// Estado para el Modal de Revisión
const isModalOpen = ref(false);
const selectedPayment = ref(null);
const rejectionMode = ref(false);

const form = useForm({
    status: '',
    rejection_reason: ''
});

const openReviewModal = (payment) => {
    selectedPayment.value = payment;
    rejectionMode.value = false;
    form.rejection_reason = '';
    isModalOpen.value = true;
};

const processPayment = (status) => {
    if (status === 'rejected' && !rejectionMode.value) {
        rejectionMode.value = true;
        return;
    }

    form.status = status;
    form.patch(route('tesoreria.payments.verify', selectedPayment.value.id), {
        onSuccess: () => {
            isModalOpen.value = false;
            selectedPayment.value = null;
        }
    });
};

// Función para saber si el voucher es PDF
const isPDF = (path) => path.toLowerCase().endsWith('.pdf');

const changeTab = (status) => {
    router.get(route('tesoreria.payments.index'), { status }, { preserveState: true });
};
</script>

<template>
    <div class="p-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-black text-gray-900 mb-8 uppercase tracking-tight">Validación de Pagos - Tesorería</h1>

            <!-- Tabs de Navegación -->
            <div class="flex space-x-4 mb-6">
                <button v-for="status in ['pending', 'approved', 'rejected']" :key="status"
                    @click="changeTab(status)"
                    :class="currentStatus === status ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-600 hover:bg-gray-100'"
                    class="px-6 py-2 rounded-xl font-bold transition-all uppercase text-xs tracking-widest border">
                    {{ status === 'pending' ? 'Pendientes' : (status === 'approved' ? 'Aprobados' : 'Rechazados') }}
                </button>
            </div>

            <!-- Tabla de Pagos -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-900 text-white uppercase text-[10px] tracking-widest font-black">
                            <th class="p-4">Alumno / DNI</th>
                            <th class="p-4">Nº Operación</th>
                            <th class="p-4">Monto</th>
                            <th class="p-4">Fecha Subida</th>
                            <th class="p-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-medium">
                        <tr v-for="payment in payments.data" :key="payment.id" class="hover:bg-blue-50/50 transition">
                            <td class="p-4">
                                <div class="text-gray-900 font-bold uppercase">{{ payment.person.names }} {{ payment.person.last_name_p }}</div>
                                <div class="text-gray-500 text-xs tracking-tighter">DNI: {{ payment.person.dni }}</div>
                            </td>
                            <td class="p-4 font-mono font-black text-blue-700">{{ payment.operation_number }}</td>
                            <td class="p-4 text-gray-900 font-bold">S/. {{ payment.amount }}</td>
                            <td class="p-4 text-gray-500 text-xs italic">{{ new Date(payment.created_at).toLocaleString() }}</td>
                            <td class="p-4 text-center">
                                <button @click="openReviewModal(payment)"
                                    class="bg-gray-900 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-blue-700 transition">
                                    REVISAR VOUCHER
                                </button>
                            </td>
                        </tr>
                        <tr v-if="payments.data.length === 0">
                            <td colspan="5" class="p-10 text-center text-gray-400 italic font-medium">No hay pagos en esta categoría.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MODAL DE REVISIÓN (THE REAL THING) -->
        <div v-if="isModalOpen" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl w-full max-w-5xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl">
                <!-- Header Modal -->
                <div class="p-6 border-b flex justify-between items-center bg-gray-50">
                    <div>
                        <h2 class="font-black text-xl text-gray-900 uppercase">Revisión de Comprobante</h2>
                        <p class="text-sm text-gray-500">Operación: {{ selectedPayment.operation_number }} | Monto: S/. {{ selectedPayment.amount }}</p>
                    </div>
                    <button @click="isModalOpen = false" class="text-gray-400 hover:text-red-500 font-black text-2xl">×</button>
                </div>

                <!-- Cuerpo Modal: Visor de Documento -->
                <div class="flex-1 overflow-y-auto p-6 bg-gray-200 flex justify-center items-start">
                    <div class="w-full max-w-3xl shadow-2xl rounded-lg overflow-hidden bg-white">
                        <!-- Si es PDF -->
                        <iframe v-if="isPDF(selectedPayment.voucher_image_path)"
                            :src="'/storage/' + selectedPayment.voucher_image_path"
                            class="w-full h-150" frameborder="0"></iframe>
                        <!-- Si es Imagen -->
                        <img v-else :src="'/storage/' + selectedPayment.voucher_image_path"
                            class="w-full h-auto" />
                    </div>
                </div>

                <!-- Footer Modal: Acciones -->
                <div class="p-6 border-t bg-white">
                    <div v-if="!rejectionMode" class="flex justify-between">
                        <button @click="processPayment('rejected')" class="bg-red-100 text-red-700 px-6 py-3 rounded-xl font-bold hover:bg-red-200 transition">
                            RECHAZAR PAGO
                        </button>
                        <button @click="processPayment('approved')" class="bg-green-600 text-white px-10 py-3 rounded-xl font-bold hover:bg-green-700 shadow-lg shadow-green-200 transition">
                            APROBAR Y HABILITAR MATRÍCULA
                        </button>
                    </div>

                    <div v-else class="space-y-4">
                        <label class="block font-bold text-gray-700 italic">Especifique el motivo del rechazo:</label>
                        <textarea v-model="form.rejection_reason" class="w-full border-2 border-red-100 rounded-xl p-3 focus:border-red-500 focus:ring-0 outline-none" placeholder="Ej: El monto no coincide con la tasa oficial..."></textarea>
                        <div class="flex space-x-3">
                            <button @click="rejectionMode = false" class="text-gray-500 font-bold px-4">Cancelar</button>
                            <button @click="processPayment('rejected')" class="bg-red-600 text-white px-6 py-2 rounded-lg font-bold">Confirmar Rechazo</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
