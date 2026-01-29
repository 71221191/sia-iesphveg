<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    payments: Array
});

const form = useForm({
    operation_number: '',
    amount: '',
    voucher: null,
});

const submit = () => {
    form.post(route('payments.store'), {
        onSuccess: () => form.reset(),
    });
};

const getStatusClass = (status) => {
    if (status === 'approved') return 'bg-green-100 text-green-800';
    if (status === 'rejected') return 'bg-red-100 text-red-800';
    return 'bg-yellow-100 text-yellow-800';
};
</script>

<template>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 text-uppercase">Mis Pagos y Vouchers</h1>

        <!-- Formulario de Registro -->
        <div class="bg-white p-6 rounded-xl shadow-sm border mb-8">
            <h2 class="font-bold mb-4 text-gray-700">Registrar Nuevo Pago</h2>
            <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Número de Operación</label>
                    <input v-model="form.operation_number" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Ej: 004587" />
                    <div v-if="form.errors.operation_number" class="text-red-500 text-xs mt-1">{{ form.errors.operation_number }}</div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Monto (S/.)</label>
                    <input v-model="form.amount" type="number" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="150.00" />
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 font-bold">Comprobante de Pago (JPG, PNG o PDF)</label>
                    <input
                        type="file"
                        @input="form.voucher = $event.target.files[0]"
                        accept=".jpg,.jpeg,.png,.pdf"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    />
                </div>

                <button :disabled="form.processing" class="md:col-span-2 bg-blue-600 text-white py-2 rounded-lg font-bold hover:bg-blue-700 transition">
                    {{ form.processing ? 'Subiendo...' : 'Registrar Voucher' }}
                </button>
            </form>
        </div>

        <!-- Lista de Pagos -->
        <div class="bg-white shadow-sm border rounded-xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 font-bold text-sm text-gray-600">Fecha</th>
                        <th class="p-4 font-bold text-sm text-gray-600">Nº Operación</th>
                        <th class="p-4 font-bold text-sm text-gray-600">Monto</th>
                        <th class="p-4 font-bold text-sm text-gray-600">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="payment in payments" :key="payment.id" class="border-b hover:bg-gray-50 transition">
                        <td class="p-4 text-sm">{{ new Date(payment.created_at).toLocaleDateString() }}</td>
                        <td class="p-4 text-sm font-mono font-bold">{{ payment.operation_number }}</td>
                        <td class="p-4 text-sm">S/. {{ payment.amount }}</td>
                        <td class="p-4">
                            <span :class="getStatusClass(payment.status)" class="px-3 py-1 rounded-full text-xs font-bold uppercase">
                                {{ payment.status === 'pending' ? 'Pendiente' : (payment.status === 'approved' ? 'Aprobado' : 'Rechazado') }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
