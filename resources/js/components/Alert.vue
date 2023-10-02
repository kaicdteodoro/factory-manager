<template>
    <v-scroll-x-transition>
        <v-alert
            v-model="alert"
            class="ma-5"
            position="fixed"
            location="top end"
            max-width="750"
            variant="tonal"
            :color="type"
            :text="message"
            :icon="`$${type}`"
            :title="title[type]"
            :closable="true"
        />
    </v-scroll-x-transition>
</template>

<script>
import {storeToRefs} from "pinia";
import {useAlertStore} from "../plugins/pinia.js";

export default {
    name: "Alert",
    data: () => ({
        alert: false,
        type: undefined,
        message: undefined,
        title: {
            success: 'Sucesso',
            info: 'Informação',
            warning: 'Alerta',
            error: 'Erro',
        }
    }),
    mounted() {
        let alert = storeToRefs(useAlertStore());
        this.type = alert.type;
        this.message = alert.message;
    },
    watch: {
        alert: {
            handler(value) {
                value ? setTimeout(() => this.alert = false, 3000) : useAlertStore().unset();
            }
        },
        message: {
            handler(value) {
                this.alert = !!value;
            }
        }
    }
}
</script>

<style scoped>
.v-alert {
    z-index: 1;
}
</style>
