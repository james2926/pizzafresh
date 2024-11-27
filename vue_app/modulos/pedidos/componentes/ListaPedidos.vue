<template>
    <v-card class="pa-3 ma-3">
        <v-toolbar flat color="#1d2735" dark>
            <v-icon class="white--text" style="font-size: 45px"
                >mdi-account-supervisor-circle</v-icon
            >
            <pre><v-toolbar-title><h2>Lista Pedidos</h2></v-toolbar-title></pre>
        </v-toolbar>
        <v-tooltip right>
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    fab
                    :to="{ path: `/guardar-pedido` }"
                    :loading="isloading"
                    :disabled="isloading"
                    color="orange darken-1"
                    class="mt-2"
                    v-bind="attrs"
                    v-on="on"
                >
                    <v-icon class="white--text"
                        >mdi-account-plus-outline</v-icon
                    >
                </v-btn>
            </template>
            <span>Nuevo Pedido</span>
        </v-tooltip>
        <v-row>
            <FilterComponent
                :headers="filter_headers"
                v-model="filtros_prueba"
            ></FilterComponent>
        </v-row>
        <v-data-table
            dense
            :loading="loading"
            :headers="headers"
            :items="Pedidos"
            :server-items-length="total_pedidos"
            :search="search"
            :items-per-page="15"
            item-key="id"
            class="elevation-1"
            :footer-props="{
                'items-per-page-options': [20, 50, 100, 500],
            }"
            @update:sort-by="updateSortBy"
            @update:sort-desc="updateSortdesc"
            @update:items-per-page="ChangeSize"
            @pagination="ChangePage"
            :item-class="
                () => {
                    return 'pointer';
                }
            "
            @click:row="
                (item) => {
                    $router.push(`/guardar-pedido?id=${item.id}`);
                }
            "
        >
            <template v-slot:item.fecha="{ item }">
                <span>{{ item.fecha | format_date_time }}</span>
            </template>
            <template v-slot:item.fecha_empaquetado="{ item }">
                <span v-if="item.fecha_empaquetado">
                    {{ item.fecha_empaquetado | format_date }}
                </span>
            </template>
            <template v-slot:item.action="{ item }">
                <v-icon
                    v-if="
                        item.id_estado != 2 &&
                        item.produccion_pedido_hoy == null
                    "
                    @click.stop="openModal(item, 2)"
                    small
                    class="mr-2"
                    style="font-size: 25px"
                    title="EMPAQUETAR"
                    >mdi-inbox</v-icon
                >
                <v-icon
                    @click.stop="openModal(item, 1)"
                    small
                    class="mr-2"
                    color="red"
                    style="font-size: 25px"
                    title="BORRAR"
                    >mdi-trash-can</v-icon
                >
            </template>
        </v-data-table>
        <v-dialog v-model="dialog_empaquetado" max-width="500px">
            <v-card>
                <v-card-title
                    class="text-h5 aviso"
                    style="
                        justify-content: center;
                        background: #1d2735;
                        color: white;
                    "
                >
                    Aviso
                </v-card-title>
                <v-card-text style="text-align: center">
                    <h2>
                        ¿Estás seguro que deseas pasa este pedido a empaquetado?
                    </h2>
                </v-card-text>
                <v-card-actions class="pt-3">
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        large
                        @click="
                            dialog = false;
                            selectedItem = {};
                        "
                        >Cancelar</v-btn
                    >
                    <v-btn color="success" large @click="empaquetar()"
                        >Confirmar</v-btn
                    >
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="dialog" max-width="500px">
            <v-card>
                <v-card-title
                    class="text-h5 aviso"
                    style="
                        justify-content: center;
                        background: #1d2735;
                        color: white;
                    "
                >
                    Aviso
                </v-card-title>
                <v-card-text style="text-align: center">
                    <h2>¿Estás seguro que deseas eliminar?</h2>
                </v-card-text>
                <v-card-actions class="pt-3">
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        large
                        @click="
                            dialog = false;
                            selectedItem = {};
                        "
                        >Cancelar</v-btn
                    >
                    <v-btn color="success" large @click="deleteUser()"
                        >Confirmar</v-btn
                    >
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-card>
</template>
<script>
import FilterComponent from "../../clientes/componentes/FilterComponent.vue";
import { debounce } from "../../../helpers";
export default {
    components: {
        FilterComponent,
    },
    watch: {
        filtros_prueba: {
            deep: true,
            handler: debounce(function () {
                this.getPedidos();
            }, 500),
        },
    },
    data() {
        return {
            dialog_empaquetado: false,
            filtros_prueba: {},
            filter_headers: [
                {
                    title: "Fecha",
                    type: "date",
                    active: false,
                    model: "fecha",
                },
            ],
            search: "",
            cantidad: 15,
            page: 0,
            total_pedidos: 0,
            headers: [
                { text: "Pedido", value: "id", sortable: true },
                { text: "Numero PrestaShop", value: "nro", sortable: true },
                { text: "Código cliente", value: "cliente.codigo_envio", sortable: true },
                {
                    text: "Cliente",
                    value: "cliente.nombre_fiscal",
                    sortable: false,
                },
                { text: "Perfil", value: "rol.descripcion", sortable: false },
                { text: "Fecha Alta", value: "fecha", sortable: true },
                { text: "Fecha de empaquetado", value: "fecha_empaquetado", sortable: true },
                { text: "Acciones", value: "action", sortable: false },
            ],
            Pedidos: [],
            selectedItem: 0,
            dialog: false,
            sortBy: null,
            sortDesc: null,
        };
    },
    created() {
        this.getPedidos();
    },
    methods: {
        updateSortdesc(data) {
            if (data == null) {
                this.sortDesc = null;
            } else {
                this.sortDesc = data;
            }

            this.getPedidos();
        },
        updateSortBy(data) {
            if (data == null) {
                this.sortBy = null;
            } else {
                this.sortBy = data;
            }

            this.getPedidos();
        },
        ChangeSize(event) {
            this.cantidad = event;
            this.getPedidos();
        },
        ChangePage(event) {
            this.page = event.page;
            this.getPedidos();
        },
        getPedidos() {
            this.loading = true;
            let fecha = "";
            if (this.filtros_prueba.fecha) {
                if (this.filtros_prueba.fecha.start) {
                    fecha += `&start=${this.filtros_prueba.fecha.start}`;
                }
                if (this.filtros_prueba.fecha.end) {
                    fecha += `&end=${this.filtros_prueba.fecha.end}`;
                }
            }

            if (this.sortBy != null) {
                fecha += `&sort_by=${this.sortBy}`;
            }
            if (this.sortDesc != null) {
                fecha += `&sort_desc=${this.sortDesc}`;
            }
            axios
                .get(
                    `api/get-pedidos?cantidad=${this.cantidad}&page=${
                        this.page
                    }${
                        this.filtros_prueba.search == null
                            ? ""
                            : `&busqueda=${this.filtros_prueba.search}`
                    }${fecha}`
                )
                .then(
                    (res) => {
                        this.loading = false;
                        this.total_pedidos = res.data.total;

                        this.Pedidos = res.data.data;
                    },
                    (err) => {
                        this.$custom_error("Error consultando Pedido");
                    }
                );
        },
        openModal(item, tipo) {
            this.selectedItem = this.Pedidos.indexOf(item);
            if (tipo == 1) {
                this.dialog = true;
            } else {
                this.dialog_empaquetado = true;
            }
        },
        empaquetar() {
            axios
                .post(
                    `api/empaquetado/pedido/${
                        this.Pedidos[this.selectedItem].id
                    }`
                )
                .then(
                    (res) => {
                        this.$toast.sucs("Agregado con exito");
                        this.dialog_empaquetado = false;
                        this.getPedidos();
                    },
                    (res) => {}
                );
        },
        deleteUser() {
            axios
                .get(`api/delete-pedido/${this.Pedidos[this.selectedItem].id}`)
                .then(
                    (res) => {
                        this.$toast.sucs("Pedido eliminado");
                        this.dialog = false;
                        this.getPedidos();
                    },
                    (err) => {
                        this.$custom_error("Error eliminando Pedido");
                    }
                );
        },
    },
    computed: {
        isloading: function () {
            // return this.$store.getters.getloading
        },
    },
};
</script>
