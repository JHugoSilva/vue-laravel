<script setup>
defineProps({
    title: String,
    type: {
        type: String,
        default: 'button'
    },
    class_btn: {
        type: String,
        default: 'btn btn-primary'
    }
})
</script>
<template>    
    <button :type="type" :class="class_btn">
        {{ title }}
        <slot name="icon"></slot>
    </button>
</template>