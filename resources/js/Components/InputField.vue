<script setup>
import { computed } from 'vue';

const props = defineProps({
    label: String,
    modelValue: [String, Number],
    type: {
        type: String,
        default: 'text'
    },
    placeholder: String,
    readonly: {
        type: Boolean,
        default: false
    },
    required: {
        type: Boolean,
        default: false
    },
    options: Array, // Para selects
    optionValue: String,
    optionLabel: String
});

const emit = defineEmits(['update:modelValue']);

const inputClasses = computed(() => {
    const base = 'w-full p-2 border rounded focus:ring-2 focus:ring-blue-500';
    return props.readonly ? `${base} bg-gray-100` : base;
});
</script>

<template>
    <div>
        <label v-if="label" class="block text-sm font-medium mb-1">
            {{ label }}
            <span v-if="required" class="text-red-500">*</span>
        </label>
        
        <!-- Select -->
        <select 
            v-if="type === 'select'"
            :value="modelValue"
            @input="emit('update:modelValue', $event.target.value)"
            :class="inputClasses"
            :required="required"
        >
            <option value="">{{ placeholder || 'Seleccionar...' }}</option>
            <option 
                v-for="option in options" 
                :key="optionValue ? option[optionValue] : option"
                :value="optionValue ? option[optionValue] : option"
            >
                {{ optionLabel ? option[optionLabel] : option }}
            </option>
        </select>

        <!-- Input -->
        <input 
            v-else
            :type="type"
            :value="modelValue"
            @input="emit('update:modelValue', $event.target.value)"
            :placeholder="placeholder"
            :readonly="readonly"
            :required="required"
            :class="inputClasses"
            :step="type === 'number' ? '0.01' : undefined"
        />
    </div>
</template>