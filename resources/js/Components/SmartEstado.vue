<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    modelValue: [String, Number],
    label: String
});

const emit = defineEmits(['update:modelValue']);

const isMobile = ref(false);

const checkMobile = () => {
    isMobile.value = window.innerWidth < 768;
};

onMounted(() => {
    checkMobile();
    window.addEventListener('resize', checkMobile);
});

onUnmounted(() => {
    window.removeEventListener('resize', checkMobile);
});

const estados = [
    { value: 1, label: 'Pendiente', color: 'bg-yellow-100 text-yellow-800 border-yellow-300' },
    { value: 2, label: 'Aprobado', color: 'bg-green-100 text-green-800 border-green-300' },
    { value: 3, label: 'Rechazado', color: 'bg-red-100 text-red-800 border-red-300' }
];
</script>

<template>
    <div>
        <label v-if="label" class="block text-sm font-medium mb-2">{{ label }}</label>
        
        <!-- MÓVIL: Select dropdown -->
        <select 
            v-if="isMobile"
            :value="modelValue"
            @change="emit('update:modelValue', parseInt($event.target.value))"
            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 bg-white text-sm"
        >
            <option v-for="estado in estados" :key="estado.value" :value="estado.value">
                {{ estado.label }}
            </option>
        </select>

        <!-- DESKTOP: Radio buttons interactivos -->
        <div v-else class="grid grid-cols-3 gap-2">
            <label 
                v-for="estado in estados" 
                :key="estado.value"
                :class="[
                    'flex items-center justify-center p-3 border-2 rounded-lg cursor-pointer transition-all duration-200 transform hover:scale-105',
                    modelValue == estado.value 
                        ? `${estado.color} border-current shadow-lg` 
                        : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50'
                ]"
            >
                <input 
                    :value="estado.value"
                    :checked="modelValue == estado.value"
                    @change="emit('update:modelValue', estado.value)"
                    type="radio" 
                    class="sr-only"
                />
                <div class="text-center">
                    <div :class="['w-3 h-3 rounded-full mx-auto mb-1', modelValue == estado.value ? 'bg-current' : 'bg-gray-300']"></div>
                    <span class="text-sm font-medium">{{ estado.label }}</span>
                </div>
            </label>
        </div>
    </div>
</template>