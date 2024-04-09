<template>
    <div class="modal bg-white w-96 sm:w-80 h-44 p-4 rounded-lg shadow-lg flex gap-8 items-center">
        <i class="fa-solid text-red-800 text-5xl w-28 h-24 flex items-center justify-center bg-red-300 p-5 rounded-lg"
            :class="icon"></i>
        <div class="text space-y-2">
            <p class="text-4xl">{{ data.fetched }}</p>
            <p>{{ data.title }}</p>
        </div>
    </div>

</template>
<script setup>
import getFromDB from '@/Composables/Getters/getFromDB';
import { ref } from 'vue';

const props = defineProps(['endpoint', 'icon'])

const data = ref([]);



getFromDB(props.endpoint).then((response) => {
    if (response) {
        data.value = response;
    } else {
        store.commit("setError", "fetching failed");
        store.commit("setErrorCode", "404");
    }
});

</script>