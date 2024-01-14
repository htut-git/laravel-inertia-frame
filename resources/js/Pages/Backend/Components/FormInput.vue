<!-- InputGroup.vue -->
<template>
    <div class="mb-3">
        <label :for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ label ?? name }}</label>
        <input :type="type" :name="name"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            :class="[error ? 'is-invalid' : '']" :id="id" :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :placeholder="placeholder ?? `Enter  ${label ?? name}`">
        <div class="invalid-feedback" v-if="error">
            {{ error }}
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    name: String,
    id: String,
    label: String,
    placeholder: String,
    type: {
        type: String,
        default: 'text'
    },
    modelValue: String,
    error: String,
});
const inputModal = computed({
    get: () => props.model,
    set: () => emit('modal:update',)
})
</script>

<style scoped>
/* Your styles go here */
</style>
