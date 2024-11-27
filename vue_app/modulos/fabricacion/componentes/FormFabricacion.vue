<template>
    <div>
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
                        <pre><v-toolbar-title><h2>Generar Orden de Fabricación</h2></v-toolbar-title></pre>
                    </v-toolbar>
                    <v-row class="mt-3">
                        <v-col cols="12" md="4">
                            <date-select
                                v-model="fecha"
                                label="Fecha de Fabricación"
                            >
                            </date-select>
                        </v-col>
                        <v-col cols="12" md="8">
                            <v-btn
                                @click="generarOrden"
                                :disabled="isloading"
                                color="success"
                                class="white--text"
                                >Generar Orden</v-btn
                            >
                            <a
                                :href="`/api/orden-fabricacion/${fecha}/export`"
                                target="__blank"
                            >
                                <v-btn
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Exportar Orden</v-btn
                                >
                            </a>
                            <v-btn
                                @click="consultarOrden"
                                :disabled="isloading"
                                color="info"
                                class="white--text"
                            >
                                Consultar Orden
                            </v-btn>
                            <v-btn
                                @click="generarOrdenUrgencia"
                                :disabled="isloading"
                                color="red"
                                class="white--text"
                                >Generar Orden de Urgencia</v-btn
                            >
                        </v-col>
                    </v-row>
                    <v-form
                        class="mt-3"
                        v-for="orden in ordenes"
                        :key="orden.id"
                    >
                        <div style="padding-bottom: 2rem">
                            <h1 v-if="orden.urgencia == 0">
                                Orden de Fabricación
                            </h1>
                            <h1 v-else>Orden de Urgencia</h1>
                        </div>

                        <v-row style="overflow-x: auto">
                            <table
                                style="
                                    min-width: 100%;
                                    border-collapse: collapse;
                                    border-spacing: 0;
                                "
                            >
                                <tr class="t-header">
                                    <th class="t-header-items">Articulo</th>
                                    <th
                                        class="t-header-items align-center"
                                        v-for="item in orden.articulos"
                                    >
                                        {{ item.articulo.nombre }}
                                    </th>
                                </tr>
                                <tr v-if="orden.urgencia == 0">
                                    <th class="t-header-items align-left">
                                        Inventario Inicial
                                    </th>
                                    <td v-for="item in orden.articulos">
                                        {{ item.inventario_inicial }}
                                    </td>
                                </tr>
                                <tr v-if="orden.urgencia == 0">
                                    <th class="t-header-items align-left">
                                        Total pedidos Año pasado
                                    </th>
                                    <td v-for="item in orden.articulos">
                                        {{ item.total_pedidos }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="t-header-items align-left">
                                        Total a Fabricar
                                    </th>
                                    <td v-for="item in orden.articulos">
                                        <v-text-field
                                            v-if="orden.finalizada == 0"
                                            @change="
                                                checkTorre(item, orden.urgencia)
                                            "
                                            outlined
                                            dense
                                            v-model="item.total_fabricar"
                                        ></v-text-field>
                                        <span v-else>{{
                                            item.total_fabricar
                                        }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="t-header-items align-left">
                                        Total a de Cajas Fabricar
                                    </th>
                                    <td v-for="item in orden.articulos">
                                        <v-text-field
                                            @change="
                                                checkCajas(item, orden.urgencia)
                                            "
                                            outlined
                                            dense
                                            v-model="item.cajas"
                                        ></v-text-field>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="t-header-items align-left">
                                        Total de Torres a Fabricar
                                    </th>
                                    <td v-for="item in orden.articulos">
                                        {{ TorreFormat(item) }}
                                    </td>
                                </tr>
                            </table>
                            <v-col cols="12">
                                <v-textarea
                                    dense
                                    outlined
                                    label="Observaciones"
                                    v-model="orden.observaciones"
                                ></v-textarea>
                            </v-col>
                        </v-row>

                        <div
                            style="
                                display: flex;
                                justify-content: space-between;
                                width: 100%;
                                padding-top: 1rem;
                            "
                        >
                            <v-btn
                                v-if="orden.finalizada == 0"
                                @click="openDialog(orden, 'actualizar')"
                                :disabled="isloading"
                                color="success"
                                class="white--text"
                                >Actualizar</v-btn
                            >
                            <v-btn
                                v-if="orden.finalizada == 0"
                                @click="openDialog(orden, 'finalizar')"
                                :disabled="isloading"
                                color="red"
                                class="white--text"
                                >Finalizar</v-btn
                            >
                        </div>
                    </v-form>
                </v-col>
            </v-row>
        </v-card>

        <v-dialog v-model="showDialog" width="500px">
            <v-card>
                <v-card-title
                    class="justify-center text-center"
                    style="background-color: rgb(29, 39, 53); color: white"
                    >Aviso</v-card-title
                >
                <v-card-text class="mt-2">
                    <div class="text-center">
                        Se ha sobrepasado la capacidad máxima de torres a
                        fabricar ({{ this.constante.capacidad_max }}) <br />
                        ¿está seguro que desea continuar?
                    </div>
                </v-card-text>
                <v-card-actions class="justify-center">
                    <v-btn
                        color="success"
                        @click="
                            action == 'actualizar'
                                ? saveOrden(orden_actual)
                                : finalizarOrden(orden_actual)
                        "
                        >Aceptar</v-btn
                    >
                    <v-btn color="error" @click="closeDialog()">Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
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
import dateSelect from "../../../components/general/dateSelect.vue";
export default {
    components: { dateSelect },
    data() {
        return {
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
            total_torres: 0,
            showDialog: false,
            orden_actual: null,
            action: "",
        };
    },
    watch: {
        menu(val) {
            val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
        },
    },
    created() {
        this.getConstantes();
    },
    methods: {
        TorreFormat(item) {
            let torres = this.Torre(item);
            const separados = torres.toFixed(0);
            const cajas =
                item.total_fabricar / item.articulo.unidades_caja -
                parseInt(separados) * item.articulo.unidades_torre;
            // console.log(cajas);
            return `${separados} ${
                cajas > 0 ? `y ${cajas.toFixed(2)} cajas` : ""
            }`;
        },
        Torre(item) {
            return this.Caja(item) / item.articulo.unidades_torre;
        },
        Caja(item) {
            return item.total_fabricar / item.articulo.unidades_caja;
        },
        checkCajas(item, urgencia) {
            console.log(item);

            item.total_fabricar = item.cajas * item.articulo.unidades_caja;
        },
        checkTorre(item, urgencia) {
            console.log(item);
            if (urgencia == 1) {
                return;
            }
            if (this.Torre(item) % 1 != 0) {
                item.total_fabricar =
                    Math.ceil(this.Torre(item)) *
                    item.articulo.unidades_caja *
                    item.articulo.unidades_torre;
                item.cajas = (
                    item.total_fabricar / item.articulo.unidades_caja
                ).toFixed(2);
                this.$toast.error("Redondeado a una torre");
            }

            this.calcularTotalTorres();
        },
        generarOrden() {
            axios.get(`api/get-orden-fabricacion/${this.fecha}`).then(
                (res) => {
                    this.ordenes = res.data;
                    this.calcularTotalTorres();
                },
                (err) => {
                    this.$custom_error("Error consultando Articulo");
                }
            );
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

        openDialog(orden, string) {
            this.action = string;
            const mensajeCapacidadMaxima =
                "Se ha sobrepasado la capacidad máxima";
            console.log(this.total_torres);
            if (
                this.total_torres > this.constante.capacidad_max &&
                this.orden_actual == null
            ) {
                if (
                    this.ordenes[0].observaciones != null &&
                    !this.ordenes[0].observaciones.includes(
                        mensajeCapacidadMaxima
                    )
                ) {
                    this.ordenes[0].observaciones =
                        this.ordenes[0].observaciones +
                        ". " +
                        mensajeCapacidadMaxima;
                }
                this.showDialog = true;
                this.orden_actual = orden;
            } else {
                if (
                    this.ordenes[0].observaciones != null &&
                    this.ordenes[0].observaciones.includes(
                        mensajeCapacidadMaxima
                    )
                ) {
                    this.ordenes[0].observaciones =
                        this.ordenes[0].observaciones.replace(
                            mensajeCapacidadMaxima,
                            ""
                        );
                }
                if (string == "actualizar") {
                    this.saveOrden(orden);
                } else {
                    this.finalizarOrden(orden);
                }
            }
        },
        closeDialog() {
            this.orden_actual = null;
            this.showDialog = false;
        },
        saveOrden(orden) {
            axios.post(`api/save-orden-fabricacion`, orden).then(
                (res) => {
                    //this.generarOrden();
                    this.orden_actual = null;
                    this.showDialog = false;
                    this.$toast.sucs("Orden Actualizada");
                },
                (err) => {
                    this.$custom_error("Error consultando Articulo");
                }
            );
        },
        finalizarOrden(orden) {
            axios.post(`api/finalizar-orden-fabricacion`, orden).then(
                (res) => {
                    this.orden_actual = null;
                    this.showDialog = false;
                    this.generarOrden();
                },
                (err) => {
                    this.$custom_error("Error");
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
        calcularTotalTorres() {
            if (this.ordenes.length > 0) {
                let total_torres = 0;
                this.ordenes.forEach((element) => {
                    if (element.articulos.length > 0) {
                        element.articulos.forEach((element2) => {
                            let torres = this.Torre(element2);
                            const separados = torres.toFixed(2);

                            /*const cajas =
                                element2.total_fabricar /
                                    element2.articulo.unidades_caja -
                                parseInt(separados) *
                                    element2.articulo.unidades_torre;

                            const cajas_redondeadas = cajas.toFixed(2);*/
                            // if(element2.total_fabricar > 0){
                            //     console.log('separados', separados)
                            //     console.log('caja', cajas_redondeadas)
                            // }

                            total_torres += parseFloat(separados);
                        });
                    }
                });

                this.total_torres = total_torres;
            }
        },

        consultarOrden(){
            if(this.fecha == '' || this.fecha == null){
                this.$custom_error("Selecciona alguna fecha a consultar");
            }else{
                axios.get(`api/consultar-orden-fabricacion/${this.fecha}`)
                .then((res) => {
                    const response = res.data.success;
                    this.ordenes = response;
                    this.calcularTotalTorres();
                })
                .catch((error) => {
                    console.log(error.response.data.error)
                    const message = error.response.data.error
                    this.$custom_error(message);
                })
            }
        }
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
    },
};
</script>
