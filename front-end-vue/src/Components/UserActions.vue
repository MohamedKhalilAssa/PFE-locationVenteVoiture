<template>
    <aside class="-translate-x-full duration-500 ease-in-out" ref="aside" v-if=!isUserMenu>
        <div class="userActions flex flex-col justify-around gap-8">
            <router-link to="/login">
                <button class="btn bg-red-500 text-white px-4 py-3 w-full hover:bg-red-700">
                    Login
                </button>
            </router-link>
            <router-link to="/register">
                <button class="btn bg-red-500 text-white px-4 py-3 w-full hover:bg-red-700">
                    register
                </button>
            </router-link>
        </div>
        <div class="userIcon absolute -right-9 top-0 cursor-pointer min-w-4 px-2 py-1" @click="showUserActions">
            <i class="fa-solid fa-user text-2xl"></i>
        </div>
    </aside>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useRoute } from 'vue-router';

const aside = ref(null);
const isUserMenu = ref(false);
const route = useRoute();
watch(route, (to, from) => {
    if (to.path !== "/register" && to.path !== "/login") {
        isUserMenu.value = false;
    } else {
        isUserMenu.value = true;
    }
});
const showUserActions = () => {
    aside.value.classList.toggle('-translate-x-full');
    if (!isUserMenu.value) {
        setTimeout(() => {
            if (aside.value) {
                if (!aside.value.classList.contains('-translate-x-full'))
                    aside.value.classList.add('-translate-x-full');
            }
        }, 4500);
    }
}
</script>

<style scoped>
aside {
    position: fixed;
    width: 200px;
    height: min-content;
    padding: 1rem;
    z-index: 51;
    left: 0;
    top: 30vh;
    background: #fff;
}

.userIcon {
    background: #fff;
}

.blockImportant {
    display: block !important;
}
</style>