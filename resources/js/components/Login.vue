<template>
    <v-container>
        <v-img
            class="mx-auto my-6"
            max-width="228"
            src="https://cdn.vuetifyjs.com/docs/images/logos/vuetify-logo-v3-slim-text-light.svg"
        ></v-img>

        <v-card
            class="mx-auto pa-12 pb-8"
            elevation="8"
            max-width="448"
            rounded="lg"
        >
            <v-form @submit.prevent="login">
                <v-label class="text-subtitle-1 text-medium-emphasis" v-text="'Usuário'"/>

                <v-text-field
                    v-model="email"
                    density="compact"
                    placeholder="Digite seu e-mail"
                    prepend-inner-icon="mdi-email-outline"
                    :rules="emailRules"
                    variant="outlined"
                />

                <v-label class="text-subtitle-1 text-medium-emphasis" v-text="'Senha'"/>

                <v-text-field
                    v-model="password"
                    :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="visible ? 'text' : 'password'"
                    density="compact"
                    placeholder="Digite sua senha"
                    prepend-inner-icon="mdi-lock-outline"
                    variant="outlined"
                    @click:append-inner="visible = !visible"
                />

                <v-card-actions>
                    <v-btn
                        block
                        color="blue"
                        size="large"
                        variant="tonal"
                        text="Entrar"
                       type="submit"
                    />
                </v-card-actions>
            </v-form>
        </v-card>
    </v-container>
</template>

<script>
import main from "../services/main.js";

export default {
    name: "Login",
    data: () => ({
        visible: false,
        email: undefined,
        password: undefined,
        emailRules: [
            v => !v || /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
        ]
    }),
    methods: {
        async login() {
            await main.login(this.email, this.password);
        }
    }
}
</script>

<style scoped>

</style>
