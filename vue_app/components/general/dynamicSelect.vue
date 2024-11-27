<template>
    <div>
        <div style="display: flex; flex-direction: row">
            <v-autocomplete
            dense outlined
                no-filter
                :rules="rules"
                v-model="id"
                :items="estados"
                :item-text="show"
                item-value="id"
                :label="title"
                autocomplete="new-item-no-fill"
            >
                <template v-slot:item="data">
                    {{ data.item[show] }}
                    <v-spacer></v-spacer>
                    <v-icon
                     v-if="!disabled"
                        @click="openEditDialog(data.item.id)"
                        small
                        class="mr-2"
                        color="#1d2735"
                        style="font-size: 25px"
                        title="EDITAR"
                        >mdi-pencil-outline</v-icon
                    >
                    <v-icon
                     v-if="!disabled"
                        @click="openDeleteDialog(data.item.id)"
                        small
                        class="mr-2"
                        color="red"
                        style="font-size: 25px"
                        title="BORRAR"
                        >mdi-trash-can</v-icon
                    >
                </template>
            </v-autocomplete>
            <v-btn
            v-if="!disabled"
              
                class="mx-2"
                fab
                dark
                small
                color="blue"
                @click="openDialog()"
            >
                <v-icon dark> mdi-plus </v-icon>
            </v-btn>
        </div>
        <v-dialog v-model="delete_dialog" max-width="500px">
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
                        @click="delete_dialog = false;"
                        >Cancelar</v-btn
                    >
                    <v-btn color="success" large @click="deleteEstado()"
                        >Confirmar</v-btn
                    >
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
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
                    Crear/Editar {{title}}
                </v-card-title>
                <v-card-text style="text-align: center">
                     <slot></slot>

                </v-card-text>
                <v-card-actions class="pt-3">
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        large
                        @click="dialog = false;"
                        >Cancelar</v-btn
                    >
                    <v-btn
                        v-if="this.update"
                        color="success"
                        large
                        @click="updateEstado()"
                        >Modificar</v-btn
                    >
                    <v-btn v-else color="success" large @click="createEstado()"
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
    props:['title','estados','show','value','disabled','rules'],
    data(){
        return{
            
            delete_dialog:false,
            dialog:false,
            update:false,
            index:-1,
            id:null,
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
            this.$emit('delete',this.id);
            this.closeDialog();

        },
     
        updateEstado(){
            this.$emit('update');
            this.closeDialog();

        },
        getIndexOfId(id){
            for(let i = 0 ; i < this.estados.length;i++){
                if(this.estados[i].id == id){
                    this.index = i;
                    break;
                }
            }
        },
        openDeleteDialog(id) {
            this.delete_dialog = true;
                        this.id = id;

        },
        openDialog() {
            this.id = null;
            this.$emit('getEstado',null);
            this.$emit('getItem',{});

            this.update = false;
            this.dialog = true;
        },
        
        openEditDialog(id) {
        
            this.id = id;
            this.$emit('getEstado',this.id);
            let item = this.estados.find(element=>element.id == this.id);
            if(item == null){
                this.$emit('getItem',{});

            }
            else{
                this.$emit('getItem',item);

            }
            this.update = true;
            this.dialog = true;
        },
    },
    mounted(){
       

    },
    watch:{
        value(n){
            this.id = n;
       
        },
        id(n){
            this.$emit('input',this.id)
        }
    }
}

</script>