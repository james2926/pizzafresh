<template>
    <div>
        <div>
        <v-subheader>
            <div style="display: flex; flex-direction: row">
                <h1>{{title}}</h1>
                <v-btn
                    style="margin-top: 10px"
                    class="mx-2"
                    fab
                    dark
                    small
                    color="blue"
                    @click="openDialog()"
                >
                    <v-icon dark> mdi-plus </v-icon>
                </v-btn>
            </div></v-subheader
        >
        <div>
            <v-data-table dense :headers="headers" :items="elementos" :search="search" :items-per-page="15" item-key="id" class="elevation-1" :sort-by="['nombre']" :sort-desc="[false]">
                <template v-for="name in slots"  v-slot:[name]="item">
                    <slot :name="name" v-bind="item"></slot>
                </template>

                <template v-slot:item.action="{ item }">
                    <v-icon
                    v-if="edit==true|edit==null"
                        @click="openEditDialog(item)"
                        small
                        class="mr-2"
                        color="#1d2735"
                        style="font-size: 25px"
                        title="EDITAR"
                        >mdi-pencil-outline</v-icon
                    >
                    <v-icon
                        @click="openDeleteDialog(item)"
                        small
                        class="mr-2"
                        color="red"
                        style="font-size: 25px"
                        title="BORRAR"
                        >mdi-trash-can</v-icon
                    >
                </template>
                    <template v-slot:item.created_at="{ item }">
                    {{item.created_at | format_date}}
                </template>
            </v-data-table>
         
        </div>
    </div>
         <!--CREATE DIRECCION-->
        <v-dialog v-model="delete_dialog" max-width="600px">
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
                            delete_dialog = false;
                        "
                        >Cancelar</v-btn
                    >
                    <v-btn color="success" large @click="deleteEstado()"
                        >Confirmar</v-btn
                    >
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="dialog" >
            <v-card>
                <v-card-title
                    class="text-h5 aviso"
                    style="
                        justify-content: center;
                        background: #1d2735;
                        color: white;
                    "
                >
                    Crear/Editar {{title}}
                </v-card-title>
                <v-card-text style="text-align: center">
                    <slot name="dialog"></slot>
                </v-card-text>
                <v-card-actions class="pt-3">
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        large
                        @click="
                            dialog = false;
                        "
                        >Cancelar</v-btn
                    >
                    <v-btn
                        v-if="update"
                        color="success"
                        large
                        @click="updateEstado()"
                        >Modificar</v-btn
                    >
                    <v-btn
                        v-else
                        color="success"
                        large
                        @click="createEstado()"
                        >Guardar</v-btn
                    >

                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
    
</template>
<script>
export default {
    props:['title','elementos','show','headers','edit','slots'],
    data(){
        return {
            search: '',
            dialog: false,
            delete_dialog: false,
            update:false,
            index:-1,
            id : null
        }
    },
    methods:{
        closeDialog(){
            this.dialog = false;
            this.delete_dialog = false;
        },
        createEstado(){
            this.$emit('create');
            this.closeDialog();
        },
        deleteEstado(){
            this.$emit('delete',this.index);
            this.closeDialog();

        },
     
        updateEstado(){
            this.$emit('update');
            this.closeDialog();

        },
        openDeleteDialog(item) {
            this.delete_dialog = true;
      
                        this.index = this.elementos.indexOf( item);
             

        },
        openDialog() {
            this.$emit('adding')
            this.id = null;

            this.update = false;
            this.dialog = true;
        },
        
        openEditDialog(item) {
            this.index = this.elementos.indexOf( item);
           
            this.$emit('getEstado',this.index);
            this.update = true;
            this.dialog = true;
        },
         getIndexOfId(id){
            for(let i = 0 ; i < this.elementos.length;i++){
                if(this.elementos[i].id == id){
                    this.index = i;
                    break;
                }
            }
        },
    }
}
</script>