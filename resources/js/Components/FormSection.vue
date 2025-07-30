<script setup>
defineProps({
    title: String,
    color: {
        type: String,
        default: 'blue'
    }
});

const getColorClasses = (color) => {
    const colors = {
        blue: 'bg-blue-600',
        green: 'bg-green-600',
        purple: 'bg-purple-600',
        gray: 'bg-gray-600'
    };
    return colors[color] || colors.blue;
};
</script>

<template>
    <div class="bg-white rounded-lg shadow border">
        <div :class="[getColorClasses(color), 'text-white p-3 rounded-t-lg']">
            <h2 class="font-semibold">{{ title }}</h2>
        </div>
        <div class="p-4">
            <slot />
        </div>
    </div>
</template>