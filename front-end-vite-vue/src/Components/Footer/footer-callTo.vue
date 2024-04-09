<template>
    <div class="footer-call-to-action">
        <h2 class="footer-call-to-action-title">{{ titre }}</h2>
        <p class="footer-call-to-action-description" v-if="description">
            {{ description }}
        </p>
        <slot></slot>
    </div>
</template>

<script setup>
const props = defineProps(['titre', 'description'])
</script>