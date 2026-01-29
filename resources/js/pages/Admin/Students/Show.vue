<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({ student: Object });
</script>

<template>
    <Head :title="student.names" />

    <div class="p-8 bg-gray-100 min-h-screen font-sans">
        <div class="max-w-5xl mx-auto">
            <!-- CAMBIO AQUÍ: Ruta manual -->
            <Link href="/admin/estudiantes" class="text-blue-600 mb-4 inline-block font-bold">← Volver al listado</Link>

            <div class="bg-white p-6 rounded-xl shadow-lg mb-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ student.last_name_p }} {{ student.last_name_m }}, {{ student.names }}</h1>
                <p class="text-gray-500 text-lg">DNI: {{ student.dni }}</p>
            </div>

            <h2 class="text-xl font-bold mb-4 border-b-2 border-gray-300 pb-2">HISTORIAL ACADÉMICO IMPORTADO</h2>

            <div v-if="student.enrollments.length === 0" class="bg-orange-100 p-4 text-orange-700 rounded-lg">
                No se encontraron registros de notas para este estudiante.
            </div>

            <div v-for="enrollment in student.enrollments" :key="enrollment.id" class="mb-10">
                <div class="bg-gray-800 text-white p-3 rounded-t-lg flex justify-between items-center">
                    <div>
                        <span class="font-bold">Periodo: {{ enrollment.academic_period.name }}</span>
                        <!-- AQUÍ SE MOSTRARÁ LA CARRERA -->
                        <span class="ml-4 text-blue-300">| Programa: {{ enrollment.study_plan.program.name }}</span>
                    </div>
                    <span class="bg-blue-600 px-2 py-1 rounded text-xs">Ciclo: {{ enrollment.cycle }}</span>
                </div>

                <div class="bg-white shadow rounded-b-lg overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-100 text-xs font-bold text-gray-600 uppercase">
                            <tr>
                                <th class="p-3 text-left">Curso / Unidad Didáctica</th>
                                <th class="p-3 text-center">Nota</th>
                                <th class="p-3 text-center">Resultado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr v-for="detail in enrollment.details" :key="detail.id">
                                <td class="p-3 text-gray-700">{{ detail.course.name }}</td>
                                <td class="p-3 text-center font-bold text-lg">{{ detail.final_score_numeric }}</td>
                                <td class="p-3 text-center">
                                    <span :class="detail.status === 'approved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
                                        class="px-3 py-1 rounded-full text-xs font-bold uppercase">
                                        {{ detail.status === 'approved' ? 'Aprobado' : 'Desaprobado' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
