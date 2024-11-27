<template>
    <v-menu
        ref="menu"
        :close-on-content-click="false"
        transition="scale-transition"
        offset-y
        min-width="auto"
    >
        <template v-slot:activator="{ on, attrs }">
            <v-text-field
                dense outlined
                :label="label"
                prepend-icon="mdi-calendar"
                v-model="fecha_altaesp"
                v-bind="attrs"
                v-on="on"
            ></v-text-field>
        </template>
        <v-date-picker first-day-of-week="1" v-model="fecha" @change="onChange($event)" no-title scrollable >
            <v-spacer></v-spacer>
            <v-btn text color="primary" @click="menu = false"> Cancel </v-btn>
            <v-btn text color="primary" @click="$refs.menu.save(fecha)">
                OK
            </v-btn>
        </v-date-picker>
    </v-menu>
</template>
<script>
    export default {
        props:['label','value', 'onChage'],
        data(){
            return{fecha:null,fecha_altaesp:"",}
        },
        created(){
            this.fecha = this.value;
            if(this.value !=null){
                this.fecha_altaesp = this.formatDate(this.fecha);
            }
        },
        updated(){
            if(this.fecha != this.value)
                this.fecha = this.value;
        },
        watch:{
            value(){
                
                this.fecha = this.value;

            },
            fecha(){
                    this.fecha_altaesp = this.formatDate(this.fecha);
                    this.$emit('input', this.fecha)
            }
        },
        computed: {
            /*fecha_altaesp(){
                return  this.formatDate(this.fecha);
            },*/
        inputListeners: function () {
            var vm = this
            // `Object.assign` merges objects together to form a new object
            return Object.assign({},
                // We add all the listeners from the parent
                this.$listeners,
                // Then we can add custom listeners or override the
                // behavior of some listeners.
                {
                // This ensures that the component works with v-model
                input: function (event) {
                    vm.$emit('input', event.target.value)
                }
                }
            )
        }
    },
        methods:{
             formatDate(date) {
                if (!date) return null;
                
                const [year, month, day] = date.split("-");
                return `${day}/${month}/${year}`;
        },
         formatDateFromEsp(date) {
                if (!date) return null;
                const [day, month, year] = date.split("/");
                return new Date(year,month-1,day).toISOString()
                    .substr(0, 10);
        },
        onChange(event){
            // console.log("4=>","test=?",this.fecha_altaesp);
            this.$emit('on-change', event);
            
            // let regex = /^((((0[1-9]|[12][0-9]|3[01])([/])(0[13578]|10|12)([/])(\d{4}))|(([0][1-9]|[12][0-9]|30)([/])(0[469]|11)([/])(\d{4}))|((0[1-9]|1[0-9]|2[0-8])([/])(02)([/])(\d{4}))|((29)(\/)(02)([/])([02468][048]00))|((29)([/])(02)([/])([13579][26]00))|((29)([/])(02)([/])([0-9][0-9][0][48]))|((29)([/])(02)([/])([0-9][0-9][2468][048]))|((29)([/])(02)([/])([0-9][0-9][13579][26]))))$/;
            
            // if(this.fecha_altaesp.match(regex)){
            //     this.fecha = this.formatDateFromEsp(this.fecha_altaesp);
            // }
            // else{
            //     this.fecha_altaesp = this.formatDate(this.fecha);

            // }
            }
        }

    }
</script>
