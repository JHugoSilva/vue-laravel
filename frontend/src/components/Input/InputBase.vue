<script setup>
defineProps({
    label: {
        type: String,
        default: ''
    },
    title: {
        type: String,
        default: ''
    },
    error_input: {
        type: Object,
        default: {}
    }
})
</script>
<template>
    <div class="col-md-6">
        <label for="label">{{ title }}</label>
        <slot name="input"></slot>
        <span v-if="error_input" class="color-text-error">{{ error_input[0] }}</span>
    </div>
</template>
<style scoped>
.color-text-error {
    color: #dc3545;
}
</style>