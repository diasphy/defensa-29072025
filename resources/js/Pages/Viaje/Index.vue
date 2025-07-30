<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    viajes: {
        type: Array,
        default: () => []
    },
    flotas: {
        type: Array,
        default: () => []
    },
    ciudades: {
        type: Array,
        default: () => []
    }
});


const getCurrentDate = () => {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0'); 
    const day = String(today.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
};


const getCurrentTime = () => {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    return `${hours}:${minutes}`;
};

const form = useForm({
    fecha: getCurrentDate(), 
    hora: getCurrentTime(),  
    cod_flota: '',
    cod_origen: '',
    cod_destino: '',
});

const getFlotaPlaca = (codFlota) => {
    const flota = props.flotas.find(f => f.id_flota === codFlota);
    return flota ? flota.placa : 'N/A';
};

const getCiudadNombre = (codCiudad) => {
    const ciudad = props.ciudades.find(c => c.id_ciudad === codCiudad);
    return ciudad ? ciudad.nombre : 'N/A';
};

const submit = () => {
    form.post(route('viajes.store'), {
        onSuccess: () => {
            form.reset();
        
            form.fecha = getCurrentDate();
            form.hora = getCurrentTime();
            alert('Registrado exitosamente!');
        },
        onError: (errors) => {
            console.error('Error al registrar :', errors);
            alert('Hubo un error al registrar. Revisa la consola para más detalles.');
        }
    });
};

const getEstadoColor = (estado) => {
    switch(estado) {
        case 1: return 'bg-green-100 text-green-800';
        case 0: return 'bg-red-100 text-red-800';
        default: return 'bg-gray-100 text-gray-800';
    }
};

const getEstadoTexto = (estado) => {
    return estado === 1 ? 'Activo' : 'Inactivo';
};
</script>

<template>
    <Head title="Registrar Viajes" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-3">
                <i class="fa-solid fa-plane-departure text-blue-600"></i>
                <span>REGISTRAR VIAJES</span>
            </div>
        </template>

        <div class="p-6">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <div class="space-y-6">
                    <div class="bg-white rounded-lg shadow border">
                        <div class="bg-blue-600 text-white p-3 rounded-t-lg">
                            <h2 class="font-semibold">Datos del Viaje</h2>
                        </div>
                        <form @submit.prevent="submit" class="p-4 space-y-3">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Fecha</label>
                                    <input v-model="form.fecha" type="date" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">
                                    <div v-if="form.errors.fecha" class="text-red-500 text-xs mt-1">{{ form.errors.fecha }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Hora</label>
                                    <input v-model="form.hora" type="time" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">
                                    <div v-if="form.errors.hora" class="text-red-500 text-xs mt-1">{{ form.errors.hora }}</div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Flota</label>
                                    <select v-model="form.cod_flota" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">
                                        <option value="">Seleccionar flota...</option>
                                        <option v-for="flota in flotas" :key="flota.id_flota" :value="flota.id_flota">
                                            {{ flota.placa }} ({{ flota.marca }})
                                        </option>
                                    </select>
                                    <div v-if="form.errors.cod_flota" class="text-red-500 text-xs mt-1">{{ form.errors.cod_flota }}</div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Ciudad Origen</label>
                                    <select v-model="form.cod_origen" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">
                                        <option value="">Seleccionar origen...</option>
                                        <option v-for="ciudad in ciudades" :key="ciudad.id_ciudad" :value="ciudad.id_ciudad">
                                            {{ ciudad.nombre }}
                                        </option>
                                    </select>
                                    <div v-if="form.errors.cod_origen" class="text-red-500 text-xs mt-1">{{ form.errors.cod_origen }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Ciudad Destino</label>
                                    <select v-model="form.cod_destino" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">
                                        <option value="">Seleccionar destino...</option>
                                        <option v-for="ciudad in ciudades" :key="ciudad.id_ciudad" :value="ciudad.id_ciudad">
                                            {{ ciudad.nombre }}
                                        </option>
                                    </select>
                                    <div v-if="form.errors.cod_destino" class="text-red-500 text-xs mt-1">{{ form.errors.cod_destino }}</div>
                                </div>
                            </div>

                            <button type="submit" :disabled="form.processing" class="w-full bg-green-600 hover:bg-green-700 disabled:opacity-50 text-white font-bold py-3 rounded-lg mt-4">
                                <i class="fa-solid fa-save mr-2"></i>
                                GUARDAR VIAJE
                            </button>
                        </form>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-lg shadow border">
                        <div class="bg-gray-600 text-white p-3 rounded-t-lg">
                            <h3 class="font-semibold">Viajes Registrados ({{ viajes.length }})</h3>
                        </div>
                        <div class="p-3 max-h-[500px] overflow-y-auto">
                            <div v-if="viajes.length === 0" class="text-center text-gray-500 py-8">
                                <p>No hay viajes registrados.</p>
                            </div>
                            <div v-else>
                                <table class="min-w-full text-sm divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cód. Viaje</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Flota</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Origen</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destino</th>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="viaje in viajes" :key="viaje.id_viaje">
                                            <td class="px-3 py-2 whitespace-nowrap">{{ 'VIA' + String(viaje.id_viaje).padStart(3, '0') }}</td>
                                            <td class="px-3 py-2 whitespace-nowrap">{{ viaje.fecha }}</td>
                                            <td class="px-3 py-2 whitespace-nowrap">{{ viaje.hora.substring(0, 5) }}</td>
                                            <td class="px-3 py-2 whitespace-nowrap">{{ getFlotaPlaca(viaje.cod_flota) }}</td>
                                            <td class="px-3 py-2 whitespace-nowrap">{{ getCiudadNombre(viaje.cod_origen) }}</td>
                                            <td class="px-3 py-2 whitespace-nowrap">{{ getCiudadNombre(viaje.cod_destino) }}</td>
                                            <td class="px-3 py-2 whitespace-nowrap">
                                                <span :class="['px-2 inline-flex text-xs leading-5 font-semibold rounded-full', getEstadoColor(viaje.estado)]">
                                                    {{ getEstadoTexto(viaje.estado) }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>