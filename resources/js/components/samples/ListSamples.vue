<template>
    <v-container>
        <v-row>
            <v-spacer/>
            <dialog-sample :type="1" @submit="loadItems"/>
        </v-row>
        <v-row>
            <template v-for="(item, index) in serverItems" :key="index">

                <v-col
                    sm="12"
                    md="4"
                >
                    <v-card
                        max-width="400"
                        elevation="5"
                    >
                        <div class="d-flex flex-no-wrap">
                            <v-avatar
                                class="ma-3"
                                size="125"
                                rounded="0"
                            >
                                <v-icon size="x-large" icon="mdi-shoe-sneaker"/>
                            </v-avatar>
                            <div>
                                <v-card-title class="text-h5" v-text="item.name"/>

                                <v-card-subtitle v-text="`código: ${item.code}`"/>
                                <v-card-subtitle v-text="`valor: ${money(item.value)}`"/>

                                <v-card-actions>
                                    <v-spacer/>
                                    <dialog-sample :sample="item" :type="2" @submit="loadItems"/>
                                    <dialog-sample :sample="item" @submit="loadItems"/>
                                </v-card-actions>
                            </div>
                        </div>
                    </v-card>
                </v-col>
            </template>
        </v-row>
        <v-row justify="center">
            <v-col cols="8">
                <v-container class="max-width">
                    <v-pagination
                        v-model="options.page"
                        :length="paginationLength"
                        class="my-4"
                    ></v-pagination>
                </v-container>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {defineAsyncComponent} from "vue";
import datatable from "../../services/datatable.js";
import {money} from "../../helpers.js";

export default {
    name: "ListSamples",
    data: () => ({
        loading: false,
        options: {
            page: 1,
            itemsPerPage: 10
        },
        totalItems: 0,
        serverItems: [],
    }),
    async mounted() {
        if (window.innerWidth <= 760) {
            this.options.itemsPerPage = 4;
        }
        await this.loadItems();
    },
    methods: {
        money,
        async loadItems() {
            this.loading = true
            await datatable.samples(this.options.page, this.options.itemsPerPage)
                .then(({items, total}) => {
                    this.totalItems = total;
                    this.serverItems = items;
                })
                .finally(() => this.loading = false);

        },
    },
    computed: {
        paginationLength() {
            return Math.floor(this.totalItems / this.options.itemsPerPage);
        },
    },
    watch: {
        options: {
            handler() {
                this.loadItems();
            },
            deep: true
        }
    },
    components: {
        DialogSample: defineAsyncComponent(() => import('./MenuSample.vue'))
    }
}
</script>

<style scoped>

</style>
