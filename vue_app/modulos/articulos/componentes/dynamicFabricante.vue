<template>
 
        <dynamic-select
                title="Fabricante"
                v-bind:estados="fabricantes"
                show="nombre"
                v-model="id"
                @create="saveFabricante"
                @delete="deleteFabricante"
                @getItem="(val)=>{fabricante = val}"
                @update="saveFabricante"
            >
            <v-row>
                <v-col cols="12">
                <v-text-field label="Nombre" v-model="fabricante.nombre" ></v-text-field>
            </v-col>
            </v-row>
        </dynamic-select>
  
</template>
<script>
    export default {
        props:['value'],
        data(){
            return{
                id: null,
                fabricante:{
                    nombre:null,
                }
            }
        },
        watch:{
            'value'(val){
                this.id = val;
            },
            'id'(val){
                this.$emit('input',val);

            }
        },
        mounted(){
            this.id = this.value;
            this.$store.dispatch('getFabricantes',this);

        },
        methods:{

            saveFabricante(){
                this.$store.dispatch('saveFabricante',this.fabricante);
            },
            deleteFabricante(id){
                this.$store.dispatch('deleteFabricante',{'id':id});
            }
        },
        computed:{
            fabricantes(){
                console.log(this.$store.getters['getfabricantes']);
                return this.$store.getters['getfabricantes']
            }
        }
    }
</script>