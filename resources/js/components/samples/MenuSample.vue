<template>
    <v-menu
        v-model="menu"
        :close-on-content-click="false"
        location="end"
    >
        <template v-slot:activator="{ props }">
            <v-btn
                v-bind="props"
                :icon="icon"
                variant="plain"
                color="white"
            />
        </template>

        <v-card min-width="300">
            <v-form @submit.prevent="submit" ref="form">
                <v-card-title v-text="title"/>

                <v-card-text>
                    <v-container v-if="type">
                        <v-row>
                            <v-col
                                cols="12"
                            >
                                <v-text-field
                                    v-model="form.code"
                                    label="Código"
                                />
                            </v-col>
                            <v-col
                                cols="12"
                            >
                                <v-text-field
                                    v-model="form.name"
                                    label="Nome"
                                />
                            </v-col>
                            <v-col
                                cols="12"
                            >
                                <v-text-field
                                    v-model="form.value"
                                    type="number"
                                    label="Valor"
                                />
                            </v-col>
                        </v-row>
                    </v-container>
                    <p v-else v-text="'Deseja realmente excluir este item?'"/>
                </v-card-text>

                <v-card-actions>
                    <v-spacer/>
                    <v-btn
                        color="error"
                        variant="plain"
                        @click="menu = false"
                        text="Cancelar"
                    />
                    <v-btn
                        color="success"
                        variant="plain"
                        type="submit"
                        text="Confirmar"
                    />
                </v-card-actions>
            </v-form>
        </v-card>
    </v-menu>
</template>

<script>
import main from "../../services/main.js";

export default {
    name: "MenuSample",
    emits: ['submit'],
    props: {
        sample: Object,
        type: {
            type: Number,
            default: 0
        }
    },
    data: () => ({
        menu: false,
        form: {
            id: undefined,
            code: '',
            name: '',
            value: 0,
        }
    }),
    mounted() {
        if (this.sample?.id) {
            this.set(this.sample);
        }
    },
    methods: {
        set(data) {
            let {id, code, name, value} = data || {};
            this.form = {id: id, code: code, name: name, value: value};
        },
        async submit() {
            const {valid} = await this.$refs.form.validate();
            if (valid) {
                await main.sample(this.form.id, this.type ? this.form : {})
                    .then(() => this.$emit('submit'));
                this.menu = false;
            }
        }
    },
    computed: {
        icon() {
            return ['mdi-trash-can', 'mdi-plus', 'mdi-pencil'][this.type];
        },
        title() {
            return ['Deletar', 'Novo', 'Editar'][this.type];
        }
    },
    watch: {
        sample: {
            handler(value) {
                this.set(value);
            },
            deep: true
        }
    }
}
</script>

<style scoped>

</style>
