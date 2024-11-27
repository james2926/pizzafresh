<template>
    <v-autocomplete :value="value" :rules="rules" :label="label" :items="items" :item-text="itemText" :item-value="itemValue" dense outlined  @input="(text)=>$emit('input', text)" v-on="$listeners">
    
    </v-autocomplete>
</template>

<script>

export default {
 
    props: {
      rules:{

      },
      outlined: {
        type: Boolean,
        default: true
      },
      label: {
        type: String,
        default:null
      },
      value: {
       
      },
      suffix:{
        type: String,
        default: ''
      },

    
                
        
                items:{},
                itemText:{},
                itemValue:{

               }},
             
   
    created(){
        console.log(this.$attrs);
    },
    mounted(){
      console.log(this['item-text']);

    }
}
</script>

<style>

</style>