<template>
    <v-card class="pa-3 ma-3">
        <v-toolbar flat color="#1d2735" dark>
            <v-icon class="white--text" style="font-size: 45px"
                >mdi-account-supervisor-circle</v-icon
            >
            <pre><v-toolbar-title><h2>Lista Clientes</h2></v-toolbar-title></pre>
        </v-toolbar>
        <v-tooltip right>
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    v-if="rol == 4 || rol == 5"
                    fab
                    @click="openModalComercial"
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
                <v-btn
                    v-else
                    fab
                    :to="{ path: `/guardar-cliente` }"
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
            <span>Nuevo Cliente</span>
        </v-tooltip>
        <v-row align="end">
            <v-col align="end" cols="12">
                <!-- <v-btn
                                   
                                    @click="showBusqueda"
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Buscar Cliente</v-btn
                        >-->
                <v-btn
                    v-if="selected.length > 0"
                    @click="EliminarSeleccionados"
                    :disabled="isloading"
                    color="red"
                    class="white--text"
                    >Eliminar</v-btn
                >
                <!--<v-btn
                                    v-if="selected.length >0 & rol != 4&rol!=5"
                                    @click="exportSelected"
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Exportar Seleccion</v-btn
                        >
                        
                         <v-btn
                                    v-else-if="rol != 4&rol!=5"
                                    @click="exportAll"
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Exportar Todo</v-btn
                        >
                        <v-btn
                                    v-if="filtros.id_agente != null"
                                    @click="exportFiltered"
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Exportar Filtrados</v-btn
                        >-->
            </v-col>
        </v-row>
        <!--Filtros-->
        <v-row>
            <v-col cols="12" md="6">
                <v-autocomplete
                    v-model="filtros.id_agente"
                    :items="agentes"
                    item-text="nombre"
                    item-value="id"
                    label="Agente"
                >
                </v-autocomplete>
            </v-col>
            <v-col cols="12" md="6">
                <v-btn @click="getClientes()"> Filtrar </v-btn>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" md="4">
                <v-text-field
                    prepend-icon="mdi-account-search"
                    v-model="search"
                    label="Buscar"
                ></v-text-field>
            </v-col>
            <!--<v-col cols="12" md="4">
                    <v-checkbox v-model="filtros.validacion" label="Pendientes Por Validación"></v-checkbox>

            </v-col>-->
        </v-row>
        <v-data-table
            dense
            v-model="selected"
            show-select
            :loading="loading"
            :headers="headers"
            :server-items-length="total_cliente"
            :items="Clientes"
            :search="search"
            :item-class="getRowClass"
            :items-per-page="15"
            item-key="id"
            class="elevation-1"
            :sort-by="['nombre']"
            :sort-desc="[false]"
            :footer-props="{
                'items-per-page-options': [20, 50, 100, 500],
            }"
            @update:items-per-page="ChangeSize"
            @pagination="ChangePage"
            @click:row="
                (item) => {
                    $router.push(`/guardar-cliente?id=${item.id}`);
                }
            "
        >
            <template v-slot:item.created_at="{ item }">
                <span>{{ item.created_at | format_date }}</span>
            </template>
            <template v-slot:item.action="{ item }">
                <v-icon
                    @click.stop="openModal(item)"
                    small
                    class="mr-2"
                    color="red"
                    style="font-size: 25px"
                    title="BORRAR"
                    >mdi-trash-can</v-icon
                >
            </template>
        </v-data-table>
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
        <v-dialog v-model="dialog_comercial" max-width="1000px">
            <v-card>
                <v-card-title
                    class="text-h5 aviso"
                    style="
                        justify-content: center;
                        background: #1d2735;
                        color: white;
                    "
                >
                    Crear Cliente
                </v-card-title>
                <v-card-text style="text-align: center">
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="cliente.razon_social"
                                label="Razón social"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="cliente.nombre_comercial"
                                label="Nombre Comercial"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-text-field
                                v-model="cliente.cif"
                                label="CIF"
                                required
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions class="pt-3">
                    <v-spacer></v-spacer>

                    <v-btn color="success" large @click="checkCliente()"
                        >Confirmar</v-btn
                    >
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <busqueda-cliente v-model="show_busqueda"></busqueda-cliente>
    </v-card>
</template>
<script>
import { debounce } from "../../../helpers";

export default {
    data() {
        return {
            show_busqueda: false,
            filtros: {
                validacion: 0,
            },
            all_selected: false,
            selected: [],
            search: "",
            page: 1,
            loading: false,
            busqueda: "buscar",
            cantidad: 15,
            total_cliente: -1,

            headers: [
                {
                    text: "Id",
                    value: "id",
                    sortable: false,
                },
                {
                    text: "Nombre",
                    value: "nombre_fiscal",
                    sortable: false,
                },
                {
                    text: "CIF",
                    value: "cif",
                    sortable: false,
                },

                { text: "Email", value: "email", sortable: false },
                { text: "Acciones", value: "action", sortable: false },
            ],
            cliente: {
                cif: null,
                razon_social: "",
                nombre_comercial: "",
            },

            Clientes: [],
            selectedItem: 0,
            dialog_comercial: false,
            dialog: false,
            rol: 0,

            agentes: [],
        };
    },
    created() {
        this.rol = localStorage.getItem("role");
        this.getAgentes();

        this.getClientes();
    },
    watch: {
        "filtros.validacion": function (val) {
            this.getClientes();
        },
        search: debounce(function (val) {
            this.getClientes();
        }, 500),
    },
    methods: {
        obtenerConocido(item) {
            let nombre = "";
            this.conocido.forEach((element) => {
                if (element.id == item.id) {
                    nombre = element.nombre;
                }
            });
            return nombre;
        },
        obtenerInteres(item) {
            let nombre = "";
            this.productos.forEach((element) => {
                if (element.id == item.id) {
                    nombre = element.nombre;
                }
            });
            return nombre;
        },
        showBusqueda() {
            this.show_busqueda = true;
        },
        getAgentes() {
            axios.get(`api/get-agentes`).then(
                (res) => {
                    this.agentes = res.data.Agentes;
                },
                (res) => {}
            );
        },
        getRowClass(item) {
            if (item.revisado == 0) {
                return "row_red pointer";
            }
            return "pointer";
        },
        downloadFile(response) {
            let blob = new Blob([response.data], { type: "xlsx" }),
                downloadUrl = window.URL.createObjectURL(blob),
                filename = "",
                disposition = response.headers["content-disposition"];

            if (disposition && disposition.indexOf("attachment") !== -1) {
                let filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/,
                    matches = filenameRegex.exec(disposition);

                if (matches != null && matches[1]) {
                    filename = matches[1].replace(/['"]/g, "");
                }
            }

            let a = document.createElement("a");
            if (typeof a.download === "undefined") {
                window.location.href = downloadUrl;
            } else {
                a.href = downloadUrl;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
            }
        },
        exportAll() {
            axios
                .get("/api/export-clientes", {
                    responseType: "blob",
                })
                .then((response) => {
                    this.downloadFile(response);
                })
                .catch(error);
        },
        exportSelected() {
            let ids = [];
            this.selected.forEach((elemento) => {
                ids.push(elemento.id);
            });
            axios
                .post(
                    "/api/export-clientes",
                    { ids: ids },
                    {
                        responseType: "blob",
                    }
                )
                .then((response) => {
                    this.downloadFile(response);
                })
                .catch(error);
        },
        exportFiltered() {
            let ids = [];

            axios
                .post(
                    "/api/export-clientes-filtered",
                    { agente: this.filtros.id_agente },
                    {
                        responseType: "blob",
                    }
                )
                .then((response) => {
                    this.downloadFile(response);
                })
                .catch(error);
        },
        EliminarSeleccionados() {
            let ids = [];
            this.selected.forEach((elemento) => {
                ids.push(elemento.id);
            });
            axios.post(`api/delete-clientes`, { ids: ids }).then(
                (res) => {
                    this.getClientes();
                    this.selected = [];
                    this.$toast.sucs("Clientes Eliminados");
                },
                (res) => {
                    this.$custom_error("Error eliminando Clientes");
                }
            );
        },
        ChangeSize(event) {
            this.cantidad = event;
            this.getClientes();
            console.log(`evento: ${event}`);
        },
        ChangePage(event) {
            this.page = event.page;
            this.getClientes();
            console.log(event);
        },
        getClientes() {
            this.loading = true;
            let filtro_agentes =
                this.filtros.id_agente != null
                    ? `&agente=${this.filtros.id_agente}`
                    : "";
            axios
                .get(
                    `api/get-clientes?cantidad=${this.cantidad}&page=${
                        this.page
                    }&busqueda=${this.search}&validacion=${
                        this.filtros.validacion ? 1 : 0
                    }` + filtro_agentes
                )
                .then(
                    (res) => {
                        this.Clientes = res.data.data;
                        this.total_cliente = res.data.total;
                        this.loading = false;
                    },
                    (err) => {
                        this.$custom_error("Error consultando Clientes");
                        this.loading = false;
                    }
                );
        },

        openModal(item) {
            this.selectedItem = this.Clientes.indexOf(item);
            this.dialog = true;
        },

        deleteUser() {
            axios
                .get(
                    `api/delete-cliente/${this.Clientes[this.selectedItem].id}`
                )

                .then(
                    (res) => {
                        this.$toast.sucs("Clientes eliminado");
                        this.dialog = false;
                        this.getClientes();
                    },
                    (err) => {
                        this.$custom_error("Error eliminando Clientes");
                    }
                );
        },
    },
    filters: {},

    computed: {
        isloading: function () {
            // return this.$store.getters.getloading
        },
    },
};
</script>
