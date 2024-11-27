<template>
 
        <dynamic-select
                title="Familia"
                v-bind:estados="familias"
                show="nombre"
                v-model="id"
                @create="saveFamilia"
                @delete="deleteFamilia"
                @getItem="(val)=>{familia = val}"
                @update="saveFamilia"
            >
            <v-row>
                <v-col cols="12">
                <v-text-field label="Nombre" v-model="familia.nombre" ></v-text-field>
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
                familia:{
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
            this.$store.dispatch('getFamilias',this);

        },
        methods:{

            saveFamilia(){
                this.$store.dispatch('saveFamilia',this.familia);
            },
            deleteFamilia(id){
                this.$store.dispatch('deleteFamilia',{'id':id});
            }
        },
        computed:{
            familias(){
                console.log(this.$store.getters['getfamilias']);
                return this.$store.getters['getfamilias']
            }
        }
    }
</script>