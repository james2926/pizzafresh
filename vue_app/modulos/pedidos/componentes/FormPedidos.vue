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
                        <pre><v-toolbar-title><h2>Crear Pedido</h2></v-toolbar-title></pre>
                    </v-toolbar>
                    <v-form class="mt-3">
                        <v-row>
                            <v-col cols="12" md="3">
                                <date-select
                                    v-model="pedido.fecha_empaquetado"
                                    label="Fecha de empaquetado"
                                >
                                </date-select>
                            </v-col>
                            <v-col cols="12" md="3">
                                <select-cliente
                                    label="Cliente"
                                    item-text="nombre_fiscal"
                                    v-model="pedido.id_cliente"
                                    :extra="pedido.cliente"
                                >
                                </select-cliente>
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-text-field-outlined
                                    v-model="pedido.gastos_envio"
                                    label="Gastos Envio"
                                    required
                                ></v-text-field-outlined>
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-text-field-outlined
                                    v-model="pedido.descuento"
                                    label="Descuento"
                                    required
                                ></v-text-field-outlined>
                            </v-col>
                        </v-row>
                        <lista-items v-model="pedido.items"></lista-items>
                        <v-row>
                            <v-col cols="12">
                                <v-btn
                                    v-if="!pedido.id"
                                    @click="savepedido"
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Guardar</v-btn
                                >
                                <v-btn
                                    v-if="pedido.id"
                                    @click="savepedido"
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Actualizar</v-btn
                                >
                                <v-btn
                                    v-if="
                                        pedido.id &&
                                        pedido.id_estado != 2 &&
                                        pedido.produccion_pedido_hoy == null
                                    "
                                    @click="empaquetar"
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Pasar a empaquetado</v-btn
                                >
                                <v-btn
                                    v-if="pedido.id"
                                    @click="deletepedido"
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
import SelectCliente from "../../clientes/componentes/clienteSelect.vue";
import ListaItems from "./ListaItems.vue";
import dateSelect from "../../../components/general/dateSelect.vue";
export default {
    data() {
        return {
            show1: false,
            menu: false,
            pedido: {
                id: null,
                email: "",
                password: "",
                id_role: -1,
                nombre: null,
                fecha_empaquetado: '',
            },
        };
    },
    watch: {
        menu(val) {
            val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
        },
    },
    created() {
        if (this.$route.query.id) {
            this.getpedido(this.$route.query.id);
        }
    },
    components: {
        SelectCliente,
        ListaItems,
        dateSelect
    },
    methods: {
        empaquetar() {
            axios.post(`api/empaquetado/pedido/${this.pedido.id}`).then(
                (res) => {
                    this.$toast.sucs("Agregado con exito");
                },
                (res) => {}
            );
        },
        getpedido(pedido_id) {
            axios.get(`api/get-pedido/${pedido_id}`).then(
                (res) => {
                    this.pedido = res.data;
                },
                (res) => {}
            );
        },
        savepedido() {
            console.log("data =>", this.pedido);
            axios
                .post("api/save-pedido", this.pedido)
                .then((res) => {
                    this.$router.push("lista-pedido");
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
        deletepedido() {
            axios.get(`api/delete-pedido/${this.pedido.id}`).then(
                (res) => {
                    this.$router.push("lista-pedido");
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
        roles() {
            return this.$store.getters.getroles;
        },
    },
};
</script>
