<template>
    <section class="form bg-gray-200">

        <form method="POST" action="" @submit.prevent="LoginHandling"
            class="bg-white border border-gray-900 shadow-2xl p-3 md:p-10 rounded max-w-lg mx-auto mb-6 mt-24">
            <header class="text-center">
                <h2 class="text-2xl font-bold uppercase mb-1">
                    Login
                </h2>
            </header>




            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2">Email</label>
                <input v-model="form.email" id="email" type="email" class="border border-gray-600 rounded p-2 w-full"
                    name="email" />
                <div class="errors" v-if="errors">
                    <p class="text-red-600" v-if="errors.email">{{ errors.email[0] }}</p>
                </div>
            </div>

            <div class="mb-6">
                <label for="password" class="inline-block text-lg mb-2">Password</label>
                <input v-model="form.password" id="password" type="password"
                    class="border border-gray-600 rounded p-2 w-full" name="password" />
                <div class="errors" v-if="errors">
                    <p class="text-red-600" v-if="errors.password">{{ errors.password[0] }}</p>
                </div>

            </div>

            <div class="mb-6">
                <button type="submit" class="bg-black text-white rounded py-2 px-4 hover:scale-105 duration-300">Se
                    Connecter</button>
            </div>

            <div class="mt-8">
                <p>
                    Vous n'avez pas de compte?
                    <router-link to="/register" class="text-blue-500 hover:scale-105 duration-300 inline-block">Creer un
                        compte </router-link>
                </p>
            </div>
        </form>
        <div class="errors max-w-lg text-center mx-auto mb-10" v-if="serverError">
            <p class="text-red-600">{{ serverError }}</p>
        </div>
    </section>
</template>
<script setup>
import { ref } from "vue"
import axios from "axios"
import { useRouter } from "vue-router"
import { useStore } from "vuex"


const form = ref({
    email: null,
    password: null
})

const user = ref(null)
const errors = ref(null)
const serverError = ref(null)
const router = useRouter()
const store = useStore()


const LoginHandling = async () => {
    axios.defaults.withCredentials = true
    axios.defaults.withXSRFToken = true
    try {
        await axios.get('http://localhost:8000/sanctum/csrf-cookie')
        await axios.post('http://localhost:8000/login', {
            email: form.value.email,
            password: form.value.password,
        })

        let { data } = await axios.get('http://localhost:8000/api/user')

        // storing the data 
        sessionStorage.setItem('Authentication', true)
        sessionStorage.setItem('User', JSON.stringify(data))
        store.commit('setAuthentication')
        store.commit('setUser')

        router.push({ name: 'home' })
    } catch (error) {
        if (error) {
            serverError.value = error.message;
        }
        if (error.response) {
            errors.value = error.response.data.errors ?? null
        }
    }
}
</script>

<style></style>