<template>
    <div>
        <v-row>
            <v-dialog v-model="dialogDeleteUser" persistent max-width="360px">
                <v-card>
                    <div class="tittlecard" style=" background-color: #1d2735 !important;font-family: monospace !important">
                        <v-custom-title text="Eliminar Usuario" class="white--text mx-4" style="font-size: 30px; font-weight: bold !important"></v-custom-title>
                    </div>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="red" class="white--text" rounded @click="deleteUser()"> Si, Eliminar </v-btn>
                        <v-btn color="green" class="white--text" rounded @click="closedialogDeleteUser()"> No, Cerrar proceso </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>
<script>
     export default {
        props: {
            dialogDeleteUser: Boolean,
            closedialogDeleteUser: Function,
            getUsuarios: Function,
            captureItem: Object,
        },

        data() {
            return {}
        },

        created() {
        },

        methods:{
            deleteUser(){
                this.closedialogDeleteUser()
                axios.get(`api/delete-usuario/${this.captureItem.item.id}`).then(res => {
                    this.getUsuarios()
                    this.$toast.sucs('Usuario eliminado');
                }, err => {
                    this.$custom_error('Error eliminando Usuario')
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
