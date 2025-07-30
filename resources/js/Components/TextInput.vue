<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    type: {
        type: String,
        default: 'text',
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="relative">
        <!-- El <slot name="icon" /> nos permite pasar un ícono desde la página de Login -->
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <slot name="icon" />
        </div>
        <input
            :type="type"
            class="w-full pl-10 pr-4 py-2 border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-brand-green-dark dark:focus:border-brand-green focus:ring-brand-green dark:focus:ring-brand-green-light rounded-md shadow-sm"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            ref="input"
        />
    </div>
</template>
