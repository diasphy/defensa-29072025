<script setup>
defineProps({
    headers: Array,
    data: Array,
    emptyMessage: {
        type: String,
        default: 'No hay datos'
    }
});

defineEmits(['row-click', 'action-click']);
</script>

<template>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th v-for="header in headers" :key="header.key" class="p-2 text-left">
                        {{ header.label }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="data.length === 0">
                    <td :colspan="headers.length" class="p-8 text-center text-gray-500">
                        {{ emptyMessage }}
                    </td>
                </tr>
                <tr v-for="(item, index) in data" :key="index" class="border-t hover:bg-gray-50 cursor-pointer"
                    @click="$emit('row-click', item)">
                    <td v-for="header in headers" :key="header.key" class="p-2">
                        <slot :name="`cell-${header.key}`" :item="item" :value="item[header.key]">
                            {{ item[header.key] }}
                        </slot>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>