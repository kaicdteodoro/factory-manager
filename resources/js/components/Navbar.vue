<template>
    <v-navigation-drawer
        v-if="show"
        class="pt-4"
        :border="0"
        :rail="true"
    >
        <v-list density="compact" variant="plain">
            <template v-for="(route, i) in routes" :key="i">
                <router-link :to="{name: route.name}" v-slot="{ isActive, navigate }" custom>
                    <v-tooltip :text="route.title">
                        <template v-slot:activator="{ props }">
                            <v-list-item
                                v-bind="props"
                                @click="navigate"
                                :active="isActive"
                                :prepend-icon="route.icon"
                            />
                        </template>
                    </v-tooltip>
                </router-link>
            </template>
            <v-spacer/>

        </v-list>
        <template v-slot:append>
            <v-list-item class="mb-5" @click="logout" prepend-icon="mdi-logout"/>
        </template>
    </v-navigation-drawer>
</template>

<script>
import {routes} from "../plugins/router/routes.js";
import main from "../services/main.js";

export default {
    name: "Navbar",
    data: () => ({
        routes: []
    }),
    mounted() {
        this.routes = routes.map((route) => ({name: route.name, icon: route.icon, title: route.meta.title}))
    },
    methods: {
        logout() {
            main.logout();
        }
    },
    computed: {
        show() {
            return this.$route.name !== 'login';
        }
    }
}
</script>

<style scoped>

</style>
