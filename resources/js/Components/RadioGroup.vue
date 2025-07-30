<script setup>
defineProps({
    label: String,
    modelValue: [String, Number],
    options: Array,
    name: String
});

const emit = defineEmits(['update:modelValue']);
</script>

<template>
    <div>
        <label v-if="label" class="block text-sm font-medium mb-2">{{ label }}</label>
        <div class="flex space-x-3">
            <label v-for="option in options" :key="option.value" class="flex items-center">
                <input 
                    :value="option.value"
                    :checked="modelValue == option.value"
                    @change="emit('update:modelValue', option.value)"
                    type="radio" 
                    :name="name"
                    class="mr-1"
                />
                <span :class="['px-3 py-1 rounded text-sm font-medium border', option.class]">
                    {{ option.label }}
                </span>
            </label>
        </div>
    </div>
</template>