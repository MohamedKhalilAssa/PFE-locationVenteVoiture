<template>
    <router-link :to="{ name: toName }" class="inline-block w-min" :class="addClass">
        <div class="brand h-full w-48 flex max-h-20 items-baseline mb-2 overflow-hidden">
            <img loading="lazy" :src="imageSrc" alt="logo" class="h-full w-full object-cover" />
        </div>
    </router-link>
</template>

<script setup>
const props = defineProps(["imageSrc", "toName", "addClass"]);

</script>