<template>
    <v-container>
        <loader v-if="isloading"></loader>
        <v-card shaped class="mx-4 my-4 pa-4">
            <v-row>
                <v-col cols="12">
                    <v-toolbar
                        flat
                        color="#1d2735"
                        dark
                        style="border-radius: 5px"
                    >
                        <v-icon class="white--text" style="font-size: 45px"
                            >mdi-account-supervisor-circle</v-icon
                        >
                        <pre><v-toolbar-title><h2>Orden de Fabricación</h2></v-toolbar-title></pre>
                    </v-toolbar>

                    <v-form
                        class="mt-3"
                        v-for="orden in ordenes"
                        :key="orden.id"
                    >
                        <v-row style="overflow-x: auto">
                           <v-col cols="12" md="4">
                                <date-select
                                    v-model="orden.fecha"
                                    @on-change="setDate"
                                    label="Fecha de Fabricación"
                                >
                                </date-select>
                            </v-col>
                            <v-col cols="12" md="8">
                                <v-btn
                                    depressed
                                    color="success"
                                    @click="fetchOrdens"
                                    >
                                    consultar orden
                                </v-btn>
                            </v-col>
                            <v-col cols="12">
                                <v-data-table
                                    dense
                                    :headers="headers"
                                    :items="orden.articulos"
                                    :items-per-page="-1"
                                    item-key="id"
                                    class="elevation-1"
                                >
                                    <template v-slot:item.torres="{ item }">
                                        {{ TorreFormat(item) }}
                                    </template>
                                </v-data-table>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-card shaped class="mt-2">
                                    <v-card-text class="text-center">
                                        TOTAL DE MASAS: {{ nro_masas | format_number }}
                                    </v-card-text>
                                </v-card>
                            </v-col>
                            <v-col cols="12">
                                <v-textarea
                                    readonly
                                    dense
                                    outlined
                                    label="Observaciones"
                                    v-model="orden.observaciones"
                                ></v-textarea>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-col>
            </v-row>
        </v-card>
    </v-container>
</template>

<style>
.t-header {
    min-width: 100%;
    background-color: rgb(29, 39, 53);
    text-align: left;
    color: white;
    padding: 1rem;
}
.align-center {
    text-align: center;
    vertical-align: center;
}
.align-left {
    text-align: left;
    vertical-align: center;
    display: flex;
    align-items: center;
}
.t-header-items {
    width: 15rem;
    padding: 0.5rem;
}
</style>

<script>
import moment from 'moment';
import dateSelect from "../../../components/general/dateSelect.vue";
export default {
    components: { dateSelect },
    data() {
        return {
            headers: [
                {
                    text: "Articulo",
                    value: "articulo.nombre",
                    sortable: false,
                },
                {
                    text: "Bolas",
                    value: "total_fabricar",
                    sortable: false,
                },
                {
                    text: "Cajas",
                    value: "cajas",
                    sortable: false,
                },
                {
                    text: "Torres",
                    value: "torres",
                    sortable: false,
                },
            ],
            curDate: null,
            show1: false,
            menu: false,
            fecha: false,
            ordenes: [
                {
                    fecha: null,
                    articulos: [],
                    urgencia: 0,
                },
            ],
            constante: {
                incremento_inv: null,
                total_gr_masa: null,
                capacidad_max: null,
            },
            // nro_masas: 0
        };
    },
    watch: {
        menu(val) {
            val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
        },
    },
    mounted() {
        // Get the current date formatted with moment
        this.curDate = moment().format('DD-MM-YYYY');
    },
    created() {
        this.generarOrden();
        this.getConstantes();
        // this.getOrden(this.fecha);
    },
    methods: {
        TorreFormat(item) {
            let torres = this.Torre(item);
            const separados = torres.toFixed(0);
            // console.log("torre", torres, separados);
            const cajas =
                item.total_fabricar / item.articulo.unidades_caja -
                parseInt(separados) * item.articulo.unidades_torre;
            return `${separados} ${
                cajas > 0 ? `y ${cajas.toFixed(2)} cajas` : ""
            }`;
        },
        Torre(item) {
            return this.Caja(item) / item.articulo.unidades_torre.toFixed(2);
        },
        Caja(item) {
            return Math.ceil(item.total_fabricar / item.articulo.unidades_caja);
        },
        checkTorre(item) {
            if ((item.total_fabricar / item.articulo.unidades_caja) % 1 != 0) {
                item.total_fabricar =
                    Math.ceil(
                        item.total_fabricar / item.articulo.unidades_caja
                    ) * item.articulo.unidades_caja;

                this.$toast.error("Redondeado a una caja");
            }
        },
        fetchOrdens(date) {
            axios.get(`api/get-orden-fabricacion-amasado/${this.curDate}`).then(
                (res) => {
                    this.ordenes = res.data.reverse();
                },
                (err) => {
                    this.$custom_error("Error consultando Articulo");
                }
            );
        },
        setDate(date) {
            this.curDate = date;
        },
        generarOrden() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, "0");
            var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
            var yyyy = today.getFullYear();

            this.curDate = `${yyyy}-${mm}-${dd}`;
            this.fetchOrdens(this.curDate);
        },
        generarOrdenUrgencia() {
            axios
                .get(`api/generar-orden-fabricacion-urgencia/${this.fecha}`)
                .then(
                    (res) => {
                        this.generarOrden();
                    },
                    (err) => {
                        this.$custom_error("Error consultando Articulo");
                    }
                );
        },
        saveOrden(orden) {
            axios.post(`api/save-orden-fabricacion`, orden).then(
                (res) => {
                    this.generarOrden();
                },
                (err) => {
                    this.$custom_error("Error consultando Articulo");
                }
            );
        },
        save(date) {
            this.$refs.menu.save(date);
        },

        getConstantes() {
            axios.get("api/get-constantes").then((res) => {
                this.constante = res.data;
            });
        },
    },
    filters: {
        format_date(fecha) {
            return moment(fecha).format("DD-MM-YYYY");
        },
    },
    computed: {
        isloading() {
            return this.$store.getters.getloading;
        },
        roles() {
            return this.$store.getters.getroles;
        },
        nro_masas() {
            let subtotal = 0;
            let total = 0;
            this.ordenes?.forEach((element) => {
                let peso_por_bolas = 0;
                element.articulos?.forEach((element2) => {
                    if (element2.articulo != null) {
                        const peso_gr = element2.articulo.peso * 1000; // la columna peso esta almacenada en kg por ejemplo 0.45kg
                        peso_por_bolas =
                            peso_gr * element2.total_fabricar;
                        subtotal += peso_por_bolas;
                    }
                });
            });

            total = subtotal / this.constante.total_gr_masa;

            return total;
        },
    },
};
</script>
