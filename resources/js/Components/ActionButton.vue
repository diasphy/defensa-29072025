<script setup>
import { computed } from 'vue';

const props = defineProps({
    variant: {
        type: String,
        default: 'primary'
    },
    size: {
        type: String,
        default: 'md'
    },
    icon: String,
    loading: {
        type: Boolean,
        default: false
    },
    disabled: {
        type: Boolean,
        default: false
    }
});

const buttonClasses = computed(() => {
    const variants = {
        primary: 'bg-blue-600 hover:bg-blue-700 text-white',
        success: 'bg-green-600 hover:bg-green-700 text-white',
        danger: 'bg-red-600 hover:bg-red-700 text-white',
        warning: 'bg-yellow-600 hover:bg-yellow-700 text-white',
        secondary: 'bg-gray-600 hover:bg-gray-700 text-white'
    };
    
    const sizes = {
        sm: 'px-3 py-1 text-sm',
        md: 'px-6 py-2',
        lg: 'px-8 py-3 text-lg',
        full: 'w-full py-3'
    };
    
    const base = 'font-medium rounded transition-colors duration-200 flex items-center justify-center';
    const disabled = props.disabled || props.loading ? 'opacity-50 cursor-not-allowed' : '';
    
    return `${base} ${variants[props.variant]} ${sizes[props.size]} ${disabled}`;
});
</script>

<template>
    <button 
        :class="buttonClasses"
        :disabled="disabled || loading"
        @click="$emit('click')"
    >
        <i v-if="loading" class="fa-solid fa-spinner fa-spin mr-2"></i>
        <i v-else-if="icon" :class="[icon, 'mr-2']"></i>
        <slot />
    </button>
</template>