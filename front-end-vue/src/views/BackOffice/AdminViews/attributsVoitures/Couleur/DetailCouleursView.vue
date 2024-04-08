<template>
    <div class="bg-white shadow rounded-lg border overflow-auto max-w-3xl mx-auto" v-if="CouleurFetched != null">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                La Couleur: {{ CouleurFetched.nom }}
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                ci-dessous les details de la couleur {{ CouleurFetched.nom }}
            </p>
        </div>
        <div class="border-t border-gray-200 px-4 py-5">
            <dl class="sm:divide-y sm:divide-gray-200">
                <div class="py-3 sm:py-5 flex items-end gap-8">
                    <dt class="text-sm font-medium text-gray-500 min-w-max">
                        Hexadecimal
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max">
                        {{ CouleurFetched.Hexadecimal }}
                    </dd>

                </div>
                <div class="py-3 sm:py-5 flex items-center gap-16">
                    <dt class="text-sm font-medium text-gray-500 min-w-max">
                        Visuel
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 min-w-max border border-black rounded-lg">
                        <div class="boxColor w-24 h-12 rounded-lg"
                            :style="{ 'background-color': CouleurFetched.Hexadecimal }">
                        </div>
                    </dd>

                </div>
            </dl>
        </div>
    </div>
</template>

<script setup>
import getById from "@/Composables/Getters/getById";
import Endpoints from "@/assets/JS/Endpoints";
import { ref } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const props = defineProps(["id"]);
const CouleurFetched = ref(null);
const router = useRouter();
const store = useStore();

// loading the brand
getById(Endpoints.couleur__get_or_update_or_delete, props.id).then((data) => {
    if (data) {
        CouleurFetched.value = data;
    } else {
        store.commit("setError", "Couleur introuvable");
        store.commit("setErrorCode", "404");
        router.push({
            name: "couleursView",
        });
    }
});

</script>
