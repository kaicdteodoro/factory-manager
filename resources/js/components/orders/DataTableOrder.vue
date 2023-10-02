<template>
    <v-container>
        <v-row justify="center" class="mb-0">
            <v-spacer/>
            <dialog-order :type="1" @submit="loadItems"/>
        </v-row>
        <v-card elevation="5">
            <v-data-table-server
                v-model:items-per-page="options.itemsPerPage"
                :headers="headers"
                :items-length="totalItems"
                :items="serverItems"
                :loading="loading"
                :search="search"
                :page="options.page"
                variant="plain"
                item-value="name"
                hide-default-footer
                @update:options="loadItems"
            >
                <template v-slot:item.actions="{ item }">
                    <div class="d-flex">
                        <dialog-order :order="item.raw" :type="2" @submit="loadItems"/>
                        <dialog-order :order="item.raw" @submit="loadItems"/>
                    </div>
                </template>

                <template v-slot:item.status="{ item }">
                    <v-chip size="small" :text="item.columns.status"/>
                </template>

                <template v-slot:item.value="{ item }">
                    <p v-text="money(item.columns.value)"/>
                </template>

                <template v-slot:item.unity="{ item }">
                    <p v-text="money(item.columns.unity)"/>
                </template>

                <template v-slot:item.quantities="{ item }">
                    <v-container>
                        <template v-for="(quantity, i) in JSON.parse(item.columns.quantities)">
                            <v-chip class="mx-1" size="x-small" w
                                    :text="`${quantity.quantity} pares n°${quantity.number}`" label/>
                        </template>
                    </v-container>
                </template>

                <template v-slot:item.desc_quantity="{ item }">
                    <v-tooltip :text="item.columns.desc_quantity">
                        <template v-slot:activator="{ props }">
                            <v-icon v-bind="props" icon="mdi-information-outline"/>
                        </template>
                    </v-tooltip>
                </template>

                <template v-slot:bottom/>
            </v-data-table-server>
        </v-card>
        <v-row justify="center">
            <v-col cols="8">
                <v-container class="max-width">
                    <v-pagination
                        v-model="options.page"
                        :length="paginationLength"
                        class="my-4"
                    />
                </v-container>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import {money} from "../../helpers.js";
import {defineAsyncComponent} from "vue";
import datatable from "../../services/datatable.js";

export default {
    name: "DataTableOrder",
    data: () => ({
        headers: [
            {title: 'Modelo', key: 'sample', align: 'start', sortable: false},
            {title: 'Status', key: 'status', align: 'start', sortable: false},
            {title: 'Quantidades', key: 'quantities', align: 'center', sortable: false},
            {title: 'Quantidade Total', key: 'quantity', align: 'center', sortable: false},
            {title: 'Observação', key: 'observation', align: 'center', sortable: false},
            {title: 'Valor Unitário', key: 'unity', align: 'start', sortable: false},
            {title: 'Valor Total', key: 'value', align: 'start', sortable: false},
            {title: 'Data', key: 'date', align: 'center', sortable: false},
            {title: '', key: 'actions', align: 'center', sortable: false},
        ],
        options: {
            page: 1,
            itemsPerPage: 5,
            sortBy: ''
        },
        search: '',
        serverItems: [],
        loading: true,
        totalItems: 0,
    }),
    methods: {
        money,
        async loadItems() {
            this.loading = true
            datatable.orders(this.options.page, this.options.itemsPerPage)
                .then(({items, total}) => {
                    this.serverItems = items;
                    this.totalItems = total;
                })
                .finally(() => this.loading = false);
        },
    },
    computed: {
        paginationLength() {
            return Math.floor(this.totalItems / this.options.itemsPerPage);
        }
    },
    components: {
        DialogOrder: defineAsyncComponent(() => import('./MenuOrder.vue'))
    }
}
</script>

<style scoped>

</style>
