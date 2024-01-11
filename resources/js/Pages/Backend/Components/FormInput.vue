<!-- InputGroup.vue -->
<template>
    <div class="mb-3">
        <label :for="id" class="form-label">{{ label ?? name }}</label>
        <input :type="type" :name="name" class="form-control" :class="[error ? 'is-invalid' : '']" :id="id"
            :value="modelValue" @input="$emit('update:modelValue', $event.target.value)"
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
