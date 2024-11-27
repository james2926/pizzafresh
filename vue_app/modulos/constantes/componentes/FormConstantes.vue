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
                        <pre><v-toolbar-title><h2>Crear Constantes</h2></v-toolbar-title></pre>
                    </v-toolbar>
                    <v-form class="mt-3">
                        <v-row>
                            <v-col cols="12" md="4">
                                <v-text-field
                                dense outlined
                                    v-model="constante.incremento_inv"
                                    label="Incremento de Inventario (%)"
                                    required
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field
                                dense outlined
                                    v-model="constante.total_gr_masa"
                                    label="Total gr por masa"
                                    required
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" md="4">
                                <v-text-field
                                dense outlined
                                    v-model="constante.capacidad_max"
                                    label="Máxima capacidad"
                                    required
                                ></v-text-field>
                            </v-col>
                        </v-row>

                        <v-row>
                            <v-col cols="12">
        
                                <v-btn
                               
                                    @click="saveConstante"
                                    :disabled="isloading"
                                    color="success"
                                    class="white--text"
                                    >Actualizar</v-btn
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
            constante: {
                incremento_inv:null,
            },
        };
    },
    watch: {
        menu(val) {
            val && setTimeout(() => (this.$refs.picker.activePicker = "YEAR"));
        },
    },
    created() {
    
            this.getConstante();

    },
    methods: {
        getConstante(usuario_id) {
            axios.get(`api/get-constantes`).then(
                (res) => {
                    if(res.data != null){
                        this.constante = res.data;
                    }
                   
                },
                (res) => {}
            );
        },
        saveConstante() {
            axios
                .post("api/save-constantes", this.constante)
                .then((res) => {
                    this.$router.go()
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
