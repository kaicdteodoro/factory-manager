<template>
    <v-app id="inspire">
        <navbar/>
        <v-main class="mt-16">
            <alert/>
            <router-view v-slot="{ Component }">
                <v-slide-x-transition>
                    <component :is="Component"/>
                </v-slide-x-transition>
            </router-view>
        </v-main>
    </v-app>
</template>

<script>
import {defineAsyncComponent} from "vue";

export default {
    name: "App",
    data: () => ({
        snackbar: true
    }),
    components: {
        Alert: defineAsyncComponent(() => import('./Alert.vue')),
        Navbar: defineAsyncComponent(() => import('./Navbar.vue')),
    }
}
</script>

<style scoped>

</style>
