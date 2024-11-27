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
                        <pre><v-toolbar-title><h2>Crear Usuarios</h2></v-toolbar-title></pre>
                    </v-toolbar>
                    <v-form class="mt-3">
                        <v-row>
                            <v-col cols="12" md="4">
                                <v-text-field-outlined
                                    v-model="usuario.name"
                                    label="Nombre"
                                    required
                                ></v-text-field-outlined>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field-outlined
                                    v-model="usuario.email"
                                    label="Email"
                                    required autocomplete="new-password"
                                ></v-text-field-outlined>
                            </v-col>
                         
                            <v-col cols="12" md="4" v-if="usuario.id == null">
                                <v-text-field-outlined prepend-icon="mdi-key"  v-model="usuario.password" label="Contraseña" required type="password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :type="show1 ? 'text' : 'password'"
                                        @click:append="show1 = !show1" autocomplete="new-password"></v-text-field-outlined>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-autocomplete-outlined
                                    v-model="usuario.id_role"
                                    :items="roles"
                                    item-text="descripcion"
                                    item-value="id"
                                    label="Roles"
                                >
                                </v-autocomplete-outlined>
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="12">
                                <v-btn
                                    v-if="!usuario.id"
                                    @click="saveusuario"
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Guardar</v-btn
                                >
                                <v-btn
                                    v-if="usuario.id"
                                    @click="updateusuario"
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Actualizar</v-btn
                                >
                                <v-btn
                                    v-if="usuario.id"
                                    @click="deleteusuario"
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
export default {
    data() {
        return {
            show1: false,
            menu: false,
            usuario: {
                id: null,
                email: "",
                password: "",
                id_role: -1,
                nombre:null
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
            this.getusuario(this.$route.query.id);
        }
    },
    methods: {
        getusuario(usuario_id) {
            axios.get(`api/getusuario/${usuario_id}`).then(
                (res) => {
                    this.usuario = res.data;
                },
                (res) => {}
            );
        },
        updateusuario() {
            axios
                .post("api/update-usuario", this.usuario)
                .then((res) => {
                    this.$router.push("lista-usuario");
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
        saveusuario() {
            axios
                .post("api/save-usuario", this.usuario)
                .then((res) => {
                    const response = res.data;

                    if(response.success){
                        this.$toast.sucs(response.message)
                    }else{
                        this.$custom_error(response.message)
                    }

                    this.$router.push("lista-usuario");
                })
                .catch((error) => {
                    // this.$custom_error(error.response.data.message);

                    if (error.response.status == 400) {                        
                        this.$custom_error(
                            "Ingrese Todos los datos correctamente"
                        );
                    } else {
                        this.$custom_error(error.response.data.message);
                    }
                });
        },
        deleteusuario() {
            axios.post("api/delete-usuario", { id: this.usuario.id }).then(
                (res) => {
                    this.$router.push("lista-usuario");
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
