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
                        <pre><v-toolbar-title><h2>Generar Orden de Produccion</h2></v-toolbar-title></pre>
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
                            <v-col cols="12" md="4">
                                <v-btn
                                    @click="consultarOrden"
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Consultar Ordenes</v-btn
                                >
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
                                    <th class="t-header-items align-left">
                                        Inventario Inicial
                                    </th>
                                    <td v-for="item in orden.articulos">
                                        {{ item.inventario }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="t-header-items align-left">
                                        Total Ventas
                                    </th>
                                    <td v-for="item in orden.articulos">
                                        {{ item.total_ventas }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="t-header-items align-left">
                                        Inventario Restante
                                    </th>
                                    <td v-for="item in orden.articulos">
                                        {{ item.total_a_fabricar }}
                                    </td>
                                </tr>
                            </table>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-data-table
                                    :item-class="row_classes"
                                    dense
                                    :headers="headers"
                                    :items="orden.pedidos"
                                    :hide-default-footer="true"
                                    :items-per-page="-1"
                                    item-key="id"
                                    class="elevation-1"
                                    :sort-by="['nombre']"
                                    :sort-desc="[false]"
                                    :expand-on-click="true"
                                    @click:row="openPedidoModal"
                                >
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
                    <v-row style="padding: 1rem">
                        <v-col cols="12" md="4">
                            <v-btn-toggle
                                v-model="selected_pedido.id_estado"
                                color="primary"
                            >
                                <v-btn :value="2"> Completado </v-btn>
                                <v-btn :value="3"> Parcial </v-btn>
                            </v-btn-toggle>
                        </v-col>
                    </v-row>

                    <v-row v-if="selected_pedido.id_estado == 3">
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
                        <v-col cols="12">
                            <v-btn color="success" @click="guardarEstado"
                                >Guardar</v-btn
                            >
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-dialog v-model="print_dialog" max-width="700px">
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
                    <v-row>
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
                                        <th class="t-header-items"></th>
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
                        <v-btn color="success" large>Confirmar</v-btn>
                    </a>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>
<style>
.bg-green{
    background-color: rgb(152, 253, 152);
}
.bg-yellow{
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
</style>
<script>
import dateSelect from "../../../components/general/dateSelect.vue";
export default {
    components: { dateSelect },
    data() {
        return {
            print_dialog: false,
            dialog: false,
            selected_pedido: { cliente: {} },
            headers: [
                { text: "Ref", value: "pedido.nro", sortable: false },
                {
                    text: "Cliente",
                    value: "pedido.cliente.nombre_fiscal",
                    sortable: false,
                },
                {
                    text: "Total Pedido",
                    value: "pedido.total_bolas",
                    sortable: false,
                },
            ],
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
        this.getHeaders();
        this.generarOrden();
        window.Echo.channel("orden-produccion").listen("NuevoPedido", (res) => {
            this.consultarOrden();
        });
    },
    methods: {
        guardarEstado() {
            axios
                .post("api/set-pedido-state", this.selected_pedido)
                .then((res) => {
                    this.consultarOrden();
                    this.dialog = false;
                });
        },
        openPedidoModal(event, item) {
            if(item.item.pedido.id_estado !=2){
                this.selected_pedido = item.item.pedido;
                this.dialog = true;
            }     
        },
        openPrintDialog() {
            this.orden.articulos.forEach((articulo) => {
                articulo.cantidad_imprimir =
                    articulo.total_a_fabricar /
                        articulo.articulo.unidades_caja -
                    articulo.etiquetas_impresas;
            });
            this.print_dialog = true;
        },
        row_classes(item) {
            console.log(item);
            if (item.pedido.id_estado == 2) {
                return "bg-green"; 
            }
            if (item.pedido.id_estado == 3) {
                return "bg-yellow"; 
            }
            return "";
        },
        getHeaders() {
            axios.get(`api/get-headers-produccion`).then(
                (res) => {
                    this.headers = res.data;
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
            return `api/get-etiquetas/${this.orden.fecha}?refs=true` + params;
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
