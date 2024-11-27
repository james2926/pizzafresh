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
                        <pre><v-toolbar-title><h2>Empaquetado</h2></v-toolbar-title></pre>
                    </v-toolbar>
                    <v-form class="mt-3">
                        <v-row>
                            <v-col cols="12" md="4">
                                <date-select
                                    v-model="orden.fecha"
                                    label="Fecha"
                                >
                                </date-select>
                            </v-col>
                            <v-col cols="12" md="8">
                                <v-btn
                                    @click="consultarOrden"
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Consultar Ordenes</v-btn
                                >
                                <a
                                    :href="`/api/empaquetado/${orden.fecha}/export`"
                                    target="__blank"
                                >
                                    <v-btn
                                        @click="exportarOrden"
                                        :disabled="isloading"
                                        color="success"
                                        class="white--text"
                                        >Exportar Orden</v-btn
                                    >
                                </a>
                                <v-btn
                                    @click="openPrintDialog"
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Imprimir Etiquetas</v-btn
                                >
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="12">
                                <v-data-table
                                    :item-class="row_classes"
                                    dense
                                    :headers="headers"
                                    :items="orden.pedidos"
                                    :items-per-page="-1"
                                    item-key="id"
                                    class="elevation-1"
                                    :sort-by="['pedido.cliente.tipo_cliente.id']"
                                    :sort-desc="[false]"
                                    :expand-on-click="true"
                                    :group-by="groupBy"
                                    @click:row="openPedidoModal"
                                >
                                    <template v-slot:[`item.pedido.cliente.nombre_fiscal`]="{ item }">
                                        <td 
                                            v-if="item.pedido.cliente.id_tipo_cliente !== null"
                                            :style="{
                                                backgroundColor: getBackgroundColor(item.pedido.cliente.id_tipo_cliente),
                                                color: 'white',
                                            }"
                                            class="truncate-text"
                                        >
                                            {{ item.pedido.cliente.nombre_fiscal }}
                                        </td>
                                        <td class="truncate-text" v-else>{{ item.pedido.cliente.nombre_fiscal }}</td>
                                    </template>
                                    <template v-slot:group.header="{ items, group }">
                                        <td :colspan="headers.length" class="group-header">
                                            <h4 class="my-2">
                                                {{items[0].pedido.cliente.tipo_cliente != null ? items[0].pedido.cliente.tipo_cliente.descripcion : '' }}
                                            </h4>
                                        </td>
                                    </template>
                                </v-data-table>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-col>
            </v-row>
        </v-card>
        <v-dialog v-model="dialog" max-width="700px">
            <v-card>
                <v-card-title
                    class="text-h5 aviso"
                    style="
                        justify-content: center;
                        background: #1d2735;
                        color: white;
                    "
                >
                    Pedido {{ selected_pedido.nro }} -
                    {{ selected_pedido.cliente.nombre_fiscal }}
                </v-card-title>
                <v-card-text style="text-align: center">
                    <v-row
                        style="padding: 1rem"
                        align="center"
                        justify="center"
                    >
                        <v-col cols="12">
                            <v-btn-toggle
                                v-model="selected_pedido.id_estado"
                                color="primary"
                            >
                                <v-btn :value="0" v-bind:key="0">
                                    Eliminar
                                </v-btn>
                                <v-btn
                                    v-for="estado in estados"
                                    :value="estado.id"
                                    v-bind:key="estado.id"
                                >
                                    {{ estado.nombre }}
                                </v-btn>
                            </v-btn-toggle>
                        </v-col>
                    </v-row>

                    <v-row
                        v-if="
                            selected_pedido.id_estado == 3 ||
                            selected_pedido.id_estado == 4
                        "
                    >
                        <v-col cols="12">
                            <div style="width: 100%; overflow: auto">
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
                                            v-for="item in selected_pedido.items"
                                        >
                                            {{ item.articulo.nombre }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="t-header-items">
                                            Cantidad Servida
                                        </th>
                                        <th
                                            class="t-header-items align-center"
                                            v-for="item in selected_pedido.items"
                                        >
                                            <v-text-field
                                                v-model="item.cantidad_servida"
                                            ></v-text-field>
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" v-if="selected_pedido.id_estado == 2">
                            <a
                                target="_blank"
                                :href="`api/save-etiqueta/${selected_pedido.id}`"
                            >
                                <v-btn color="primary"
                                    >Imprimir Etiqueta</v-btn
                                ></a
                            >
                        </v-col>
                        <v-col cols="12">
                            <v-btn
                                v-if="selected_pedido.id_estado == 0"
                                color="red"
                                class="white--text"
                                @click="elminarEstado"
                                >Eliminar</v-btn
                            >
                            <v-btn v-else color="success" @click="guardarEstado"
                                >Guardar</v-btn
                            >
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-dialog v-model="print_dialog">
            <v-card>
                <v-card-title
                    class="text-h5 aviso"
                    style="
                        justify-content: center;
                        background: #1d2735;
                        color: white;
                    "
                >
                    Imprimir
                </v-card-title>
                <v-card-text style="text-align: center">
                    <v-row style="padding-top: 2rem">
                        <v-col cols="6">
                            <date-select
                                label="Consumo Preferente"
                                v-model="emision"
                            ></date-select>
                        </v-col>
                        <v-col cols="6">
                            <v-btn-toggle v-model="idioma" color="primary">
                                <v-btn :value="1">Español</v-btn>
                                <v-btn :value="2">Portugués</v-btn>
                            </v-btn-toggle>
                        </v-col>
                        <v-col cols="12">
                            <div style="width: 100%; overflow: auto">
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
                                    <tr>
                                        <th class="t-header-items">Cantidad</th>
                                        <th
                                            class="t-header-items align-center"
                                            v-for="item in orden.articulos"
                                        >
                                            <v-text-field
                                                label="Cantidad"
                                                v-model="item.cantidad_imprimir"
                                            ></v-text-field>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th class="t-header-items">Imprimir</th>
                                        <th
                                            class="t-header-items align-center"
                                            v-for="item in orden.articulos"
                                        >
                                            <a
                                                target="__blank"
                                                :href="imprimirIndividual(item)"
                                            >
                                                <v-btn
                                                    color="primary"
                                                    class="white--text"
                                                    >Imprimir</v-btn
                                                >
                                            </a>
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions class="pt-3">
                    <v-btn color="error" large @click="print_dialog = false"
                        >Cancelar</v-btn
                    >
                    <a target="__blank" :href="imprimir">
                        <v-btn color="success" large>Imprimir Todas</v-btn>
                    </a>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<style>
.bg-green {
    background-color: rgb(152, 253, 152);
}
.bg-yellow {
    background-color: rgb(252, 239, 125);
}
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
.truncate-text {
  white-space: nowrap;        /* Evita el salto de línea */
  overflow: hidden;           /* Oculta el texto que excede el ancho */
  text-overflow: ellipsis;    /* Muestra los puntos suspensivos */
}
</style>
<script>
import dateSelect from "../../../components/general/dateSelect.vue";
export default {
    components: { dateSelect },
    data() {
        return {
            selected_pedido_produccion: null,
            idioma: 1,
            emision: {},
            print_dialog: false,
            dialog: false,
            estados: [],
            selected_pedido: { cliente: {} },
            headers: [
                // { text: "Ref", value: "pedido.id", sortable: false },
                {
                    text: "Cliente",
                    value: "pedido.cliente.nombre_fiscal",
                    sortable: false,
                },
                {
                    text: "Código envió",
                    value: "pedido.cliente.codigo_envio",
                    sortable: false,
                },
                {
                    text: "Total Pedido",
                    value: "pedido.total_cajas",
                    sortable: false,
                },
            ],
            groupBy: "pedido.cliente.tipo_cliente.id",
            show1: false,
            menu: false,
            orden: {
                fecha: null,
                articulos: [],
            },
            constante: {
                incremento_inv: null,
            },
        };
    },
    watch: {
        menu(val) {
            val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
        },
    },
    created() {
        this.getEstados();
        this.getHeaders();
        this.generarOrden();
        window.Echo.channel("orden-produccion").listen("NuevoPedido", (res) => {
            this.consultarOrden();
            this.getHeaders();
        });
    },
    methods: {
        getBackgroundColor(id_tipo_cliente) {
            if (id_tipo_cliente === 1) {
                return "#2196f3";
            } else if (id_tipo_cliente === 2) {
                return "#9c27b0";
            } else if (id_tipo_cliente === 3) {
                return "#f44336";
            } else if (id_tipo_cliente === 4) {
                return "#ff9800";
            } else {
                return "";
            }
        },
        imprimirIndividual(articulo) {
            let params = "";

            params +=
                "&" + articulo.articulo.ref + "=" + articulo.cantidad_imprimir;

            if (this.emision != null) params += `&caducidad=${this.emision}`;
            return (
                `api/get-etiquetas/${this.orden.fecha}?lan=${this.idioma}` +
                params
            );
        },
        getEstados() {
            axios.get("api/get-estados-pedido").then((res) => {
                this.estados = res.data;
            });
        },
        guardarEstado() {
            axios
                .post("api/set-pedido-state", this.selected_pedido)
                .then((res) => {
                    this.consultarOrden();
                    this.dialog = false;
                });
        },
        elminarEstado() {
            axios
                .delete(
                    `api/empaquetado/pedido/${this.selected_pedido_produccion.id}`
                )
                .then((res) => {
                    this.consultarOrden();
                    this.dialog = false;
                });
        },
        openPedidoModal(event, item) {
            //if (item.item.pedido.id_estado != 2) {
                this.selected_pedido = item.item.pedido;
                this.selected_pedido.fecha_cambio_estado = this.orden.fecha;
                this.selected_pedido_produccion = item.item;
                this.dialog = true;
            //}
        },
        openPrintDialog() {
            this.orden.articulos.forEach((articulo) => {
                articulo.cantidad_imprimir =
                    articulo.total_a_fabricar /
                        articulo.articulo.unidades_caja -
                    articulo.etiquetas_impresas;
            });
            this.emision = null;
            this.print_dialog = true;
        },
        row_classes(item) {
            // console.log(item);
            if (item.pedido.id_estado == 2) {
                return "bg-green";
            }
            if (item.pedido.id_estado == 3 || item.pedido.id_estado == 4) {
                return "bg-yellow";
            }
            return "";
        },
        getHeaders() {
            axios.get(`api/get-headers-produccion`).then(
                (res) => {
                    this.headers = res.data.filter((header, index) => index !== 0);;
                },
                (err) => {
                    this.$custom_error("Error consultando Articulo");
                }
            );
        },
        consultarOrden() {
            axios.get(`api/get-produccion/${this.orden.fecha}`).then(
                (res) => {
                    this.orden = res.data;
                },
                (err) => {
                    this.$custom_error("Error consultando Articulo");
                }
            );
        },
        generarOrden() {
            axios.post(`api/generate-produccion`).then(
                (res) => {
                    this.orden = res.data;
                    // console.log("pedidos=>",this.orden.pedidos);
                },
                (err) => {
                    this.$custom_error("Error consultando Articulo");
                }
            );
        },
        saveOrden() {
            axios.post(`api/save-orden-fabricacion`, this.orden).then(
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
        exportarOrden(){
            //
        }
    },
    filters: {
        format_date(fecha) {
            return moment(fecha).format("DD-MM-YYYY");
        },
    },
    computed: {
        imprimir() {
            let params = "";
            this.orden.articulos.forEach((articulo) => {
                params +=
                    "&" +
                    articulo.articulo.ref +
                    "=" +
                    articulo.cantidad_imprimir;
            });
            if (this.emision != null) params += `&caducidad=${this.emision}`;
            return (
                `api/get-etiquetas/${this.orden.fecha}?lan=${this.idioma}` +
                params
            );
        },
        isloading() {
            return this.$store.getters.getloading;
        },
        roles() {
            return this.$store.getters.getroles;
        },
    },
};
</script>
