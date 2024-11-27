<template>
    <v-card class="pa-3 ma-3">
        <v-toolbar flat color="#1d2735" dark>
            <v-icon class="white--text" style="font-size: 45px"
                >mdi-account-supervisor-circle</v-icon
            >
            <pre><v-toolbar-title><h2>Lista logs</h2></v-toolbar-title></pre>
        </v-toolbar>

        <v-row>
            <v-col cols="12" md="4">
                <v-text-field-outlined
                    prepend-icon="mdi-account-search"
                    v-model="search"
                    label="Buscar"
                ></v-text-field-outlined>
            </v-col>
        </v-row>
        <v-data-table
            dense
            :headers="headers"
            :items="logs"
            :search="search"
            :items-per-page="15"
            item-key="id"
            class="elevation-1"
            :sort-by="['nombre']"
            :sort-desc="[false]"
        >
            <template v-slot:item.created_at="{ item }">
                {{ item.created_at | format_date }}
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
export default {
    data() {
        return {
            search: "",
            headers: [
                { text: "Nombre", value: "user.email", sortable: false },
                { text: "Accion", value: "accion.nombre", sortable: false },
                { text: "Fecha", value: "created_at", sortable: false },
            ],
            logs: [],
            selectedItem: 0,
            dialog: false,
        };
    },

    created() {
        this.getArticulos();
    },
    methods: {
        getArticulos() {
            axios.get(`api/get-log`).then(
                (res) => {
                    this.logs = res.data;
                },
                (err) => {
                    this.$custom_error("Error consultando log");
                }
            );
        },
        openModal(item) {
            this.selectedItem = this.logs.indexOf(item);
            this.dialog = true;
        },
        deleteUser() {
            axios.get(`api/delete-log/${this.logs[this.selectedItem].id}`).then(
                (res) => {
                    this.$toast.sucs("log eliminado");
                    this.dialog = false;
                    this.getArticulos();
                },
                (err) => {
                    this.$custom_error("Error eliminando log");
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
