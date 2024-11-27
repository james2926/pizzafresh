<template>
    <v-card class="pa-3 ma-3">
        <v-toolbar flat color="#1d2735" dark>
            <v-icon class="white--text" style="font-size: 45px"
                >mdi-account-supervisor-circle</v-icon
            >
            <pre><v-toolbar-title><h2>Lista Articulos</h2></v-toolbar-title></pre>
        </v-toolbar>
        <v-tooltip right>
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    fab
                    :to="{ path: `/guardar-articulo` }"
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
            <span>Nuevo Articulo</span>
        </v-tooltip>
        <v-row>
            <filter-component 
                v-model="filtros_prueba"
                :headers="filter_headers"
                :item = "opciones_familia"
                :multiple = true
            />
        </v-row>
        <v-data-table
            :item-class="
                () => {
                    return 'pointer';
                }
            "
            @click:row="
                (item) => {
                    $router.push(`/guardar-articulo?id=${item.id}`);
                }
            "

            dense
            :headers="headers"
            :items="Articulos"
            :server-items-length="total_articulos"
            :search="search"
            :items-per-page="15"
            item-key="id"
            class="elevation-1"
            :footer-props="{
                'items-per-page-options': [20, 50, 100, 500],
            }"
            @update:items-per-page="ChangeSize"
            @pagination="ChangePage"
            :sort-by="['nombre']"
            :sort-desc="[false]"
        >
            <template v-slot:item.fecha_alta="{ item }">
                <span>{{ item.fecha_alta }}</span>
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
    </v-card>
</template>
<script>
import FilterComponent from "../../clientes/componentes/FilterComponent.vue";
import { debounce } from '../../../helpers';
export default {
    components: { FilterComponent },
    data() {
        return {
            page: 0,
            cantidad: 15,
            search: "",
            headers: [
                { text: "id", value: "id", sortable: false },
                { text: "Ref", value: "ref", sortable: false },
                { text: "Nombre", value: "nombre", sortable: false },
                { text: "Descripcion", value: "descripcion", sortable: false },
                {
                    text: "Principal",
                    value: "produccion.nombre",
                    sortable: true,
                },

                { text: "Cantidad", value: "cantidad", sortable: false },
                { text: "Peso", value: "peso", sortable: false },
                { text: "Acciones", value: "action", sortable: false },
            ],
            filter_headers: [
                {
                    title: "Familia",
                    type: "select",
                    active: false,
                    model: "opciones_familia",
                    item_text: "nombre",
                    item_value: "id",
                    items: this.opciones_familia,
                },
            ],
            total_articulos: 0,
            opciones_familia: [],
            Articulos: [],
            selectedItem: 0,
            dialog: false,
        };
    },
    computed: {
        isloading: function () {
            // return this.$store.getters.getloading
        },
        filtros_prueba: {
            get() {
                return this.$store.getters['getFiltrosPrueba'];
            },
            set(newValue) {
                this.setFiltrosPrueba(newValue);
            }
        },
        page: {
            get() {
                return this.$store.getters['getPage'];
            },
            set(newValue) {
                this.setFiltrosPrueba(newValue);
            }
        },
        cantidad: {
            get() {
                return this.$store.getters['getCantidad'];
            },
            set(newValue) {
                this.setFiltrosPrueba(newValue);
            }
        }
    },
    watch: {
        filtros_prueba: {
            deep: true,
            handler: debounce(function (newValue) {
                this.getArticulos();
            }, 500),
        },
    },
    created() {
        this.getArticulos();
        this.getFamilias();
    },
    methods: {
        ChangePage(event) {
            this.page = event.page;
            this.getArticulos();
        },
        ChangeSize(event) {
            this.cantidad = event;
            this.getArticulos();
        },
        getArticulos() {
            let familias = [];
            if (this.filtros_prueba.opciones_familia) {
                familias = this.filtros_prueba.opciones_familia.value;
            }

            const params = {
                cantidad: this.cantidad,
                page: this.page,
                busqueda: this.filtros_prueba.search || null,
                familias: familias,
            };

            axios
                .get('api/filter-articulos', { params })
                .then(
                    (res) => {
                        this.total_articulos = res.data.total;
                        this.Articulos = res.data.data;
                    },
                    (err) => {
                        this.$custom_error("Error consultando Pedido");
                    }
                );

        },
        setFiltrosPrueba(filtros) {
            this.$store.dispatch('updateFiltrosPrueba', filtros);
        },
        setPage(page) {
            this.$store.dispatch('updatePage', page);
        },
        setCantidad(cantidad) {
            this.$store.dispatch('updateCantidad', cantidad);
        },
        getFamilias() {
            axios.get(`api/get-articulo-familias`).then(
                (res) => {
                    res.data.map((value, index) => {
                        let item = {};
                        Object.assign(item, {value: value.id, text: value.nombre});
                        this.opciones_familia.push(item);
                        this.filter_headers[0].items = this.opciones_familia;
                    });
                },
                (err) => {
                    this.$custom_error("Error consultando articulos");
                }
            );
        },
        // getArticulos() {
        //     axios.get(`api/get-articulos`).then(
        //         (res) => {
        //             this.Articulos = res.data;
        //         },
        //         (err) => {
        //             this.$custom_error("Error consultando Articulo");
        //         }
        //     );
        // },
        openModal(item) {
            this.selectedItem = this.Articulos.indexOf(item);
            this.dialog = true;
        },
        deleteUser() {
            axios
                .get(
                    `api/delete-articulo/${
                        this.Articulos[this.selectedItem].id
                    }`
                )
                .then(
                    (res) => {
                        this.$toast.sucs("Articulo eliminado");
                        this.dialog = false;
                        this.getArticulos();
                    },
                    (err) => {
                        this.$custom_error("Error eliminando Articulo");
                    }
                );
        },
    },
};
</script>
