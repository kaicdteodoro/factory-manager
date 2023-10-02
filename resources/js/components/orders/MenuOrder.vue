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
                :size="type === 1 ? 'large' : 'x-small'"
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
                                <v-autocomplete
                                    v-model="form.sample_id"
                                    :clearable="true"
                                    label="Modelo"
                                    :items="samples"
                                />
                            </v-col>
                            <v-col
                                cols="12"
                            >
                                <v-select
                                    label="Status"
                                    v-model="form.order_status_id"
                                    :items="status"
                                />
                            </v-col>
                            <v-col
                                cols="12"
                            >
                                <v-text-field
                                    v-model="form.observation"
                                    label="Observação"
                                />
                            </v-col>
                            <v-col
                                cols="12"
                            >
                                <v-label text="Quantidades" class="mb-2"/>
                                <br/>
                                <template v-for="(quantity, i) in form.quantities" :key="i">
                                    <v-fab-transition>
                                        <v-chip class="ma-2" size="large" :closable="true" @click:close="removeQuantity(i)">
                                            <v-select
                                                v-model="form.quantities[i].number"
                                                class="pt-1"
                                                variant="plain"
                                                :items="fillNumbers"
                                                density="comfortable"
                                                hide-selected
                                            />
                                            <v-text-field
                                                v-model="form.quantities[i].quantity"
                                                variant="plain"
                                                density="comfortable"
                                                class="pl-2 pt-1"
                                            />
                                        </v-chip>
                                    </v-fab-transition>
                                </template>
                                <v-chip class="ma-2" size="large">
                                    <v-btn icon="mdi-plus" variant="text" @click="addQuantity"/>
                                </v-chip>
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
        order: Object,
        type: {
            type: Number,
            default: 0
        }
    },
    data: () => ({
        menu: false,
        status: [],
        samples: [],
        numbers: [],
        form: {
            id: undefined,
            sample_id: undefined,
            order_status_id: undefined,
            observation: undefined,
            quantities: []
        }
    }),
    async mounted() {
        this.status = await main.status();
        this.samples = await main.samples();
        this.numbers = await main.numbers();
        if (this.order?.id) {
            this.set(this.order);
        }
    },
    methods: {
        set(value) {
            let {id, sample_id, status_id, observation, quantities} = value || {};
            this.form = {
                id: id,
                sample_id: sample_id,
                order_status_id: status_id,
                observation: observation,
                quantities: JSON.parse(quantities)
            };
        },
        async submit() {
            const {valid} = await this.$refs.form.validate();
            if (valid) {
                await main.order(this.form.id, this.type ? this.form : {})
                    .then(() => this.$emit('submit'));
                this.menu = false;
            }
        },
        addQuantity() {
            this.form.quantities.push({number: undefined, quantity: undefined});
        },
        removeQuantity(index) {
            this.form.quantities.splice(index, 1);
        }
    },
    computed: {
        icon() {
            return ['mdi-trash-can', 'mdi-plus', 'mdi-pencil'][this.type];
        },
        title() {
            return ['Deletar', 'Novo', 'Editar'][this.type];
        },
        fillNumbers() {
            return this.numbers.filter(number => !this.form.quantities.some(quantity => quantity.number === number))
        }
    },
    watch: {
        order: {
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
