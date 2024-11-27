<template>
    <div>
        <div class="d-flex justify-end" style="width: 100%;">
            <v-icon 
                color="info" 
                class="pointer ml-3" 
                @click="alert = true"
                v-if="alert == false"
            >
                mdi-information
            </v-icon>
            <v-alert
                v-model="alert" 
                dismissible 
                type="info" 
                border="top"
                colored-border
                elevation="2"
                style="width: 100%;"
            >
                La receta correponde a la cantidad de ingredientes que conforman una caja del articulo
            </v-alert>
        </div>
        
        <v-row>
            <v-col cols="12">
                <v-btn white-text color="primary" @click="openDialog(false)">Agregar Ingrediente</v-btn>
            </v-col>
            <v-col>
                <v-data-table :items="recetas" :headers="headers">
                    <template v-slot:item.action="{ item }">
                        <v-icon @click="openDialog(item)" small class="mr-2" color="#1d2735" style="font-size: 25px;" title="EDITAR">mdi-pencil-outline</v-icon>
                    
                        <v-icon @click="Delete(item)" small class="mr-2" color="red" style="font-size: 25px;" title="BORRAR">mdi-trash-can</v-icon>
                    </template>
                </v-data-table>
            </v-col>
            
            <v-dialog v-model="dialog" max-width="500px">
                <v-card>
                    <v-card-title
                        class="text-h5 aviso"
                        style="justify-content: center;
                            background: #1d2735;
                            color: white;"
                    >
                        Crear/Editar Receta
                    </v-card-title>
                    <v-card-text style="text-align: center;padding-top:1rem">
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-autocomplete v-model="receta.id_ingrediente" label="Ingrediente"  dense outlined item-text="ref" item-value="id" :items="Articulos"></v-autocomplete>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field dense outlined v-model="receta.cantidad" label="Cantidad" type="number"></v-text-field>
                        </v-col>
                    </v-row>

                    </v-card-text>
                    <v-card-actions class="pt-3">
                        <v-spacer></v-spacer>
                        <v-btn
                            color="error"
                            large
                            @click="dialog = false;"
                            >Cancelar</v-btn
                        >
                        <v-btn v-if="index_selected != null" color="success" large @click="update()"
                            >Actualizar</v-btn
                        >
                        <v-btn v-else color="success" large @click="create()"
                            >Guardar</v-btn
                        >

                        <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </div>
</template>
<script>
export default {
    props:['value'],
    data(){
        return{
            headers: [
                {text: 'Ref', value: 'ingrediente.ref',sortable: false},
                {text: 'Cantidad (uds)',value: 'cantidad',sortable: false},
                {text: 'Acciones',value: 'action',sortable: false},
            ],
            dialog:false,
            index_selected:null,
            receta:{},
            Articulos:[],
            recetas:[],
            alert: true
        }
    },
    mounted(){
        if(this.value ){
            this.recetas = this.value;

        }
        this.getArticulos();
    },
    watch:{
        'value':{
            deep: true,
            handler:function(val){
                if(val){
                    this.recetas = val;

                }
                else{
                    this.recetas = [];

                }
            }
        },
        'recetas':{
            deep: true,
            handler:function(val){
                console.log(val);
                this.$emit('input', val);
            }
        }
    },
    methods:{
        Delete(item){
            let index = this.recetas.indexOf(item);
            this.recetas = this.recetas.splice(index,1);
        },
        putIngrediente(){
            let ingrediente = this.Articulos.find(element=>element.id == this.receta.id_ingrediente );
            this.receta.ingrediente = ingrediente;
        },
        update(){
            if(this.index_selected != null){
                this.putIngrediente();
                this.recetas[this.index_selected] = this.receta;
                this.recetas.push({});
                this.recetas = this.recetas.splice(this.recetas.length-1,1);
                this.receta = {}; 
            }
            this.dialog = false;

        },
        create(){
            if(this.index_selected){
                this.update();
            }else{
                this.putIngrediente();

this.recetas.push(this.receta);
console.log(this.recetas);
this.receta = {};
this.dialog = false;
            }
          
        },
        openDialog(item){
            this.dialog = true;
            if(item){
      
                this.index_selected = this.recetas.indexOf(item);
                console.log(this.index_selected);
                this.receta = JSON.parse(JSON.stringify(item));
            }
            else{
                this.receta =  {};
                this.index_selected = null;
            }
        },
        getArticulos() {
            axios.get(`api/get-articulos`).then(res => {
                this.Articulos = res.data
            }, err => {
                this.$custom_error('Error consultando Articulos')
            })
        },
    }
}
</script>