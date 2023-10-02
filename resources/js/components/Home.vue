<template>
    <v-container>
        <v-card>

            <Bar
                id="my-chart-id"
                v-if="labelValue?.length"
                :options="chartOptions"
                :data="{
            labels: labelValue,
            datasets: [{ label: 'Rendimento Mensal',data: dataValue, backgroundColor: 'gray'}]
        }"
            />
        </v-card>
    </v-container>
</template>

<script>
import {Bar} from 'vue-chartjs';
import main from "../services/main.js";
import {Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    name: "Home",
    data: () => ({
        data: undefined,
        months: {
            1: 'Janeiro',
            2: 'Fevereiro',
            3: 'Março',
            4: 'Abril',
            5: 'Maio',
            6: 'Junho',
            7: 'Julho',
            8: 'Agosto',
            9: 'Setembro',
            10: 'Outubro',
            11: 'Novembro',
            12: 'Dezembro',
        },
        chartData: {
            labels: ['January', 'February', 'March'],
            datasets: [{data: [40, 20, 12]}]
        },
        chartOptions: {
            responsive: true
        }
    }),
    async mounted() {
        this.data = await main.chartMonth();
        this.chartData.labels = this.label;
        this.chartData.datasets = [{data: this.dataValue}];
        console.log(this.chartData);

    },
    computed: {
        labelValue() {
            return this.data?.map(data => this.months[data.month]);
        },
        dataValue() {
            return this.data?.map(data => data.value);
        }
    },
    components: {
        Bar
    }
}
</script>

<style scoped>

</style>
