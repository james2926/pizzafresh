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
                        <pre><v-toolbar-title><h2>Crear Clientes</h2></v-toolbar-title></pre>
                    </v-toolbar>
                    <v-form ref="form" class="mt-3">
                        <v-row>
                            <v-col cols="12" md="4">
                                <v-text-field-outlined
                                    :rules="requiredRule"
                                    v-model="cliente.nombre"
                                    label="Nombre"
                                    required
                                ></v-text-field-outlined>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field-outlined
                                    :rules="requiredRule"
                                    v-model="cliente.apellidos"
                                    label="Apellidos"
                                    required
                                ></v-text-field-outlined>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field-outlined
                                    :rules="requiredRule"
                                    v-model="cliente.nombre_fiscal"
                                    label="Nombre Fiscal"
                                    required
                                ></v-text-field-outlined>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field-outlined
                                    v-model="cliente.cif"
                                    label="CIF"
                                    required
                                ></v-text-field-outlined>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field-outlined
                                    :rules="requiredRule"
                                    v-model="cliente.email"
                                    label="Email"
                                    required
                                ></v-text-field-outlined>
                            </v-col>
                            <v-col cols="12" md="4">
                                <date-select
                                    label="Fecha de Nacimiento"
                                    v-model="cliente.fecha_nacimiento"
                                >
                                </date-select>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-autocomplete-outlined
                                    :rules="requiredRule"
                                    v-model="cliente.id_grupo"
                                    :items="grupos"
                                    item-text="nombre"
                                    item-value="id"
                                    label="Grupo"
                                >
                                </v-autocomplete-outlined>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field-outlined
                                    v-model="cliente.codigo_envio"
                                    label="Código envío"
                                    required
                                ></v-text-field-outlined>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-autocomplete-outlined
                                    :rules="requiredRule"
                                    v-model="cliente.id_tipo_cliente"
                                    :items="tipoCliente"
                                    item-text="descripcion"
                                    item-value="id"
                                    label="Tipo Cliente"
                                >
                                </v-autocomplete-outlined>
                            </v-col>
                        </v-row>
                        <v-row
                            v-for="direccion in direcciones"
                            :key="direccion.nombre"
                        >
                            <v-col cols="12">
                                <h3>Dirección de {{ direccion.nombre }}</h3>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field-outlined
                                    v-model="cliente[direccion.campo].telefono"
                                    label="Telefono"
                                    required
                                ></v-text-field-outlined>
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-autocomplete-outlined
                                    v-model="cliente[direccion.campo].id_pais"
                                    :items="paises"
                                    item-text="nombre"
                                    item-value="id"
                                    label="Pais"
                                >
                                </v-autocomplete-outlined>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field-outlined
                                    v-model="cliente[direccion.campo].ciudad"
                                    label="Ciudad"
                                    required
                                ></v-text-field-outlined>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field-outlined
                                    v-model="
                                        cliente[direccion.campo].codigo_postal
                                    "
                                    label="Código Postal"
                                ></v-text-field-outlined>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field-outlined
                                    v-model="cliente[direccion.campo].direccion"
                                    label="Direccion"
                                    required
                                ></v-text-field-outlined>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-btn
                                    v-if="!cliente.id"
                                    @click="savecliente"
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Guardar</v-btn
                                >
                                <v-btn
                                    v-if="cliente.id"
                                    @click="savecliente"
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Actualizar</v-btn
                                >
                                <v-btn
                                    v-if="cliente.id"
                                    @click="deletecliente"
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
import dateSelect from "../../../components/general/dateSelect.vue";
export default {
    components: { dateSelect },
    data() {
        return {
            requiredRule: [(v) => (v != null && v != "") || "Es Obligatorio"],

            show1: false,
            menu: false,
            direcciones: [
                {
                    nombre: "envio",
                    campo: "direccion_envio",
                },
                {
                    nombre: "facturacion",
                    campo: "direccion_facturacion",
                },
            ],
            cliente: {
                direccion_facturacion: {},
                direccion_envio: {},
            },
        };
    },
    watch: {
        menu(val) {
            val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
        },
    },
    created() {
        this.$store.dispatch("getGruposCliente", this);
        this.$store.dispatch("getTipoCliente", this);
        if (this.$route.query.id) {
            this.getcliente(this.$route.query.id);
        }
    },
    methods: {
        getcliente(cliente_id) {
            axios.get(`api/get-cliente/${cliente_id}`).then(
                (res) => {
                    this.cliente = res.data;
                    if (this.cliente.direccion_facturacion == null)
                        this.cliente.direccion_facturacion = {};
                    if (this.cliente.direccion_envio == null)
                        this.cliente.direccion_envio = {};
                },
                (res) => {}
            );
        },

        savecliente() {
            if (!this.$refs.form.validate()) return;
            axios
                .post("api/save-cliente", this.cliente)
                .then((res) => {
                    this.$router.push("lista-clientes");
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
        deletecliente() {
            axios.post("api/delete-cliente", { id: this.cliente.id }).then(
                (res) => {
                    this.$router.push("lista-clientes");
                },
                (res) => {}
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
        isloading() {
            return this.$store.getters.getloading;
        },
        grupos() {
            return this.$store.getters.getgruposclientes;
        },
        paises() {
            return this.$store.getters.getpais;
        },
        tipoCliente() {
            return this.$store.getters.getTipoCliente;
        }
    },
};
</script>
