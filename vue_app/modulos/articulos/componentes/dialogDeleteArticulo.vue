<template>
    <div>
        <v-row>
            <v-dialog v-model="dialog" persistent max-width="360px">
                <v-card>
                    <v-card-title class="text-h5 aviso" style="justify-content: center; background:#1d2735; color:white">
                        Aviso
                    </v-card-title>
                    <v-card-text style="text-align:center">
                        <h2>¿Estás seguro que deseas eliminar?</h2>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="red" class="white--text" rounded @click="deleteUser()"> Si </v-btn>
                        <v-btn color="green" class="white--text" rounded @click="closedialogDeleteUser()"> No </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>
<script>
     export default {
        props: {
            value: Boolean,
            getArticulos: Function,
            captureItem: Object,
        },

        data() {
            return {
                dialog:false,
            }
        },

        created() {
            this.dialog = this.value
        },

        methods:{
            closedialogDeleteUser(){
                this.dialog = false;
            },
            deleteUser(){

                this.closedialogDeleteUser()
                axios.get(`api/delete-articulo/${this.captureItem.item.id}`).then(res => {
                    this.getArticulos()
                    this.$toast.sucs('Articulo eliminado');
                }, err => {
                    this.$custom_error('Error eliminando Articulo')
                })
            },
        }
     };
</script>

<style>
    .tittlecard {
        padding-top: 15px !important;
        padding-bottom: 15px !important;
        margin-bottom: 30px !important;
        background-color: rgb(222, 222, 222) !important;
    }
</style>
