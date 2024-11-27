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
                        <pre><v-toolbar-title><h2>Crear Articulos</h2></v-toolbar-title></pre>
                    </v-toolbar>
                    <v-form class="mt-3">
                        <v-row>
                            <v-tabs v-model="tab" align-tabs="center">
                                <v-tab>Datos</v-tab>
                                <v-tab>Etiqueta</v-tab>
                                <v-tab>Receta</v-tab>

                                <v-tab-item>
                                    <v-form ref="form">
                                        <v-row style="padding: 1rem">
                                            <v-col cols="12" md="2">
                                                <v-text-field-outlined
                                                    v-model="articulo.sorting_index"
                                                    label="Orden"
                                                    required
                                                    :rules="requiredRule"
                                                ></v-text-field-outlined>
                                            </v-col>
                                            <v-col cols="12" md="3">
                                                <v-text-field-outlined
                                                    v-model="articulo.ref"
                                                    label="Referencia"
                                                    required
                                                    :rules="requiredRule"
                                                ></v-text-field-outlined>
                                            </v-col>
                                            <v-col cols="12" md="4">
                                                <v-text-field-outlined
                                                    v-model="articulo.nombre"
                                                    label="Nombre"
                                                    required
                                                    :rules="requiredRule"
                                                ></v-text-field-outlined>
                                            </v-col>
                                            <v-col cols="12" md="3">
                                                <v-text-field-outlined
                                                    v-model="articulo.precio"
                                                    label="Precio"
                                                    required
                                                ></v-text-field-outlined>
                                            </v-col>
                                            <v-col cols="12" md="4">
                                                <dynamicFamilia
                                                    v-model="
                                                        articulo.id_familia
                                                    "
                                                >
                                                </dynamicFamilia>
                                            </v-col>
                                            <v-col cols="12" md="4">
                                                <dynamic-fabricante
                                                    v-model="
                                                        articulo.id_fabricante
                                                    "
                                                >
                                                </dynamic-fabricante>
                                            </v-col>
                                            <v-col cols="12" md="4">
                                                <v-text-field-outlined
                                                    v-model="articulo.peso"
                                                    label="Peso"
                                                    required
                                                ></v-text-field-outlined>
                                            </v-col>
                                            <v-col cols="12" md="4">
                                                <v-text-field-outlined
                                                    v-model="articulo.cantidad"
                                                    label="Cantidad (uds)"
                                                    required
                                                ></v-text-field-outlined>
                                            </v-col>
                                            <v-col cols="12" md="8">
                                                <div
                                                    style="
                                                        display: flex;
                                                        justify-content: space-between;
                                                    "
                                                >
                                                    <v-switch
                                                        v-model="
                                                            articulo.venta_stock
                                                        "
                                                        label="Permite la venta sin stock"
                                                        color="primary"
                                                    ></v-switch>

                                                    <v-switch
                                                        v-model="
                                                            articulo.ingrediente
                                                        "
                                                        label="Ingrediente"
                                                        color="primary"
                                                    ></v-switch>

                                                    <v-switch
                                                        v-model="
                                                            articulo.principal
                                                        "
                                                        label="Principal"
                                                        color="primary"
                                                    ></v-switch>
                                                </div>
                                            </v-col>
                                            <v-col cols="12" md="4">
                                                <v-autocomplete
                                                    v-model="
                                                        articulo.id_produccion
                                                    "
                                                    label="Produccion"
                                                    dense
                                                    outlined
                                                    item-text="nombre"
                                                    item-value="id"
                                                    :items="produccion"
                                                ></v-autocomplete>
                                            </v-col>

                                            <v-col cols="12" md="4">
                                                <v-text-field-outlined
                                                    v-model="
                                                        articulo.unidades_caja
                                                    "
                                                    label="Unidades por Caja"
                                                    required
                                                ></v-text-field-outlined>
                                            </v-col>
                                            <v-col cols="12" md="4">
                                                <v-text-field-outlined
                                                    v-model="
                                                        articulo.unidades_torre
                                                    "
                                                    label="Cajas por Torre"
                                                    required
                                                ></v-text-field-outlined>
                                            </v-col>
                                            <v-col cols="12">
                                                <v-textarea
                                                    dense
                                                    outlined
                                                    v-model="
                                                        articulo.descripcion
                                                    "
                                                    label="Descripcion"
                                                    :rules="requiredRule"
                                                    required
                                                ></v-textarea>
                                            </v-col>
                                        </v-row>
                                    </v-form>
                                </v-tab-item>
                                <v-tab-item>
                                    <v-col cols="12" md="4">
                                        <v-autocomplete
                                            v-model="articulo.id_tipo_etiqueta"
                                            label="Tipo de Etiqueta"
                                            dense
                                            outlined
                                            item-text="nombre"
                                            item-value="id"
                                            :items="tipos_etiqueta"
                                        ></v-autocomplete>
                                    </v-col>
                                </v-tab-item>
                                <v-tab-item>
                                    <v-col cols="12">
                                        <lista-recetas
                                            v-model="articulo.recetas"
                                        ></lista-recetas>
                                    </v-col>
                                </v-tab-item>
                            </v-tabs>
                        </v-row>

                        <v-row>
                            <v-col cols="12">
                                <v-btn
                                    v-if="!articulo.id"
                                    @click="savearticulo"
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Guardar</v-btn
                                >
                                <v-btn
                                    v-if="articulo.id"
                                    @click="savearticulo"
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Actualizar</v-btn
                                >
                                <v-btn
                                    v-if="articulo.id"
                                    @click="deletearticulo"
                                    :disabled="isloading"
                                    color="red"
                                    class="white--text"
                                    >Eliminar</v-btn
                                >
                            </v-col>
                        </v-row>
                    </v-form>
                </v-col>
            </v-row>
        </v-card>
    </v-container>
</template>

<script>
import dynamicFamilia from "./dynamicFamilia.vue";
import dynamicFabricante from "./dynamicFabricante.vue";
import ListaRecetas from "./ListaRecetas.vue";
export default {
    data() {
        return {
            requiredRule: [(v) => (v != null && v != "") || "Es Obligatorio"],
            Articulos: [],
            tab: 0,
            show1: false,
            menu: false,
            articulo: {
                recetas: [],
            },
            produccion: [],
        };
    },
    watch: {
        menu(val) {
            val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
        },
    },
    created() {
        this.getProduccion();
        this.$store.dispatch("getTipoEtiquetas");
        if (this.$route.query.id) {
            this.getarticulo(this.$route.query.id);
        }
    },
    methods: {
        getProduccion() {
            axios.get(`api/get-articulos-produccion`).then(
                (res) => {
                    this.produccion = res.data;
                },
                (err) => {
                    this.$custom_error("Error consultando articulos");
                }
            );
        },
        getarticulo(articulo_id) {
            axios.get(`api/get-articulo/${articulo_id}`).then(
                (res) => {
                    this.articulo = res.data;
                },
                (res) => {}
            );
        },

        savearticulo() {
            if (!this.$refs.form.validate()) return;

            axios
                .post("api/save-articulo", this.articulo)
                .then((res) => {
                    this.$router.push("lista-articulo");
                })
                .catch((error) => {
                    if (error.response.status == 400) {
                        this.$custom_error(
                            "Ingrese Todos los datos correctamente"
                        );
                    } else {
                        this.$custom_error("Algo salio mal");
                    }
                });
        },
        deletearticulo() {
            axios.get(`api/delete-articulo${this.articulo.id}`).then(
                (res) => {
                    this.$router.push("lista-articulo");
                },
                (res) => {}
            );
        },
    },
    components: {
        dynamicFamilia,
        dynamicFabricante,
        ListaRecetas,
    },
    computed: {
        isloading() {
            return this.$store.getters.getloading;
        },
        tipos_etiqueta() {
            return this.$store.getters.gettipo_etiquetas;
        },
    },
};
</script>
