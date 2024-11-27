<template>
    <div style="display: flex; flex-direction: column">
    <v-card>
        <v-card-title>
            Añadir por rango
        </v-card-title>
        <v-card-text>
              <div class="row">
        <v-col cols="6" md="3">  
            <date-select v-model="initial_date" label="Inicio">

            </date-select>
        </v-col>
        <v-col cols="6" md="3">
            <v-text-field-outlined label="Cantidad" v-model="rango">

            </v-text-field-outlined>
        </v-col>
       <v-col cols="6" md="3">
            <date-select v-model="final_date" label="Final">

            </date-select>
        </v-col>
         <v-col cols="6" md="3">
              <v-btn
                               
                              
                                    color="primary"
                                    class="white--text"
                                    @click="AnadirRango"
                                    >Añadir Rango</v-btn
                                >
        </v-col>
         </div>
        </v-card-text>
       
   
    </v-card>
   
        <div class="picker-header">
            <button  type="button" @click="PreviousMonday">
                <svg
                xmlns="http://www.w3.org/2000/svg"
                class="picker-header-arrow"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 19l-7-7 7-7"
                />
            </svg>
            </button>
            
            <h2>
                {{meses[currentDate.format("M")] }}
            </h2>
            <button  type="button" @click="NextMonday">
  <svg
                xmlns="http://www.w3.org/2000/svg"
                class="picker-header-arrow"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 5l7 7-7 7"
                />
            </svg>
            </button>
          
        </div>
        <h1></h1>
        <div style="display: grid; grid-template-columns: 14.25% 14.25% 14.25% 14.25% 14.25% 14.25% 14.25%; justify-content: space-evenly">
            <div v-for="dia in dias_nombres" :key="dia" class="dia" style="    border-bottom: 1px solid rgb(216, 216, 216);">
                {{dia}}
            </div >
            
            <div
                v-for="dia in dias"
                :key="dia.fecha"
                style="
                    display: flex;
                    flex-direction: column;
                    flex: 1;
                    align-items: center;
                "
            >
                <div class="dia">
                    <div>{{ dia.nombre }}</div>
                    <div class="numero">{{ dia.fecha.format("D") }}</div>
                </div>
                <div :class="dia.cantidad >0 ?'amountButton':'amountButton-0'">
                    <button  type="button" @click="subtractElemento(dia)" class="addbutton">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="iconbutton"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M18 12H6"
                            />
                        </svg>
                    </button>
                    <div class="amountNumber">{{dia.cantidad}}</div>
                    <button type="button" v-if="maxReached" @click="addElemento(dia,1)" class="addbutton">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="iconbutton"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                            />
                        </svg>
                    </button>
                    <div v-else class="addbutton">

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
import dateSelect from '../dateSelect.vue';

export default {
  components: { dateSelect },
    props:['value','maxReached','disponibles','lv','fd'],
    data() {
        return {
            initial_date:null,
            final_date:null,
            rango:0,
            currentDate: moment().startOf('month'),
            meses:['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            dias_nombres:["Lu","Ma","Mi","Ju","Vi","Sa","Do"],
            dias: [
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                { fecha: moment.now() ,cantidad:0},
                
            ],
            elementos:[

            ]
        };
    },
    watch:{
        currentDate(){
            this.getDates();
        },
         elementos(){
                
                    this.$emit('input', this.elementos);
            }
    },
    created(){
        console.log('date created');
        this.elementos = this.value;
        this.updateElementos();

    },
    updated(){
                console.log('date updated');

        this.elementos = this.value;
        console.log(this.elementos);
        this.updateElementos();
    },
    methods: {
    CountRango(){
        let conteo = 0;
        if(this.initial_date == null || this.final_date == null){
                this.$custom_error("Debe llenar ambos campos de fecha");
                return;
            }
            console.log('fecha');
            let inicio = moment(this.initial_date);
            let fin = moment(this.final_date).add(1,'day');
            while(! inicio.isSameOrAfter(fin,'date')){
                let fecha_temp = moment(inicio.toString());
                var dayOfWeek = fecha_temp.day();
                console.log(dayOfWeek)
                var isWeekend = (dayOfWeek === 6) || (dayOfWeek  === 0); 
                var isWeekDay = !isWeekend;

                if(this.lv == null || this.lv == true){
                    
                    if(isWeekDay){
                         conteo += parseFloat(this.rango);

                    }
                }
                   if(this.fd == null || this.fd == true){
                    
                    if(isWeekend){
                         conteo += parseFloat(this.rango);

                    }
                }
                inicio.add(1,'day');
            }
            return conteo;
    },
    AnadirRango(){
         if(!this.lv&!this.fd){
                    this.$custom_error('Debe Seleccionar una zona horaria');
                    return;
                }
            if(this.initial_date == null || this.final_date == null){
                this.$custom_error("Debe llenar ambos campos de fecha");
                return;
            }
            console.log('fecha');
            let inicio = moment(this.initial_date);
            let fin = moment(this.final_date).add(1,'day');
            let cantidad = this.CountRango();
            console.log(`cantidad: ${cantidad}`);
            if(cantidad > this.disponibles){
                 this.$custom_error(`La cantidad introducida es mayor que los disponibles por: ${cantidad-this.disponibles} unidades`);
                return;
            }
        
            while(! inicio.isSameOrAfter(fin,'date')){
                let fecha_temp = moment(inicio.toString());
                var dayOfWeek = fecha_temp.day();
                console.log(dayOfWeek)
                var isWeekend = (dayOfWeek === 6) || (dayOfWeek  === 0); 
                var isWeekDay = !isWeekend;

                if(this.lv == null || this.lv == true){
                    
                    if(isWeekDay){
                                        this.addElemento({fecha:fecha_temp},this.rango);

                    }
                }
                   if(this.fd == null || this.fd == true){
                    
                    if(isWeekend){
                                        this.addElemento({fecha:fecha_temp},this.rango);

                    }
                }
               
                inicio.add(1,'day');
            }
       
            this.updateElementos();
        },
        addElemento(date,cantidad){
            
            let elemento = this.searchElemento(date.fecha);
            if(elemento == null){
                elemento = {cantidad:cantidad,fecha:date.fecha};
             
                this.elementos.push(elemento);
            }
            else{
                elemento.cantidad = parseFloat(elemento.cantidad)+ parseFloat(cantidad); 
            }
            date.cantidad = elemento.cantidad;
             this.$emit('update');
        },
        subtractElemento(date){
            
            let elemento = this.searchElemento(date.fecha);
            if(elemento != null ){
                if(elemento.cantidad == 1)
                {
              
                    this.elementos.splice(this.elementos.indexOf(elemento),1);
               
                    date.cantidad = 0;
                }
                else{
                    elemento.cantidad --; 
                    date.cantidad = elemento.cantidad;

                }
            }
           
            

        },
        updateElementos(){
            this.dias.forEach(dia=>{
                let elemento = this.searchElemento(dia.fecha);
                if(elemento !=null){
                    dia.cantidad = elemento.cantidad;
                }else{
                    dia.cantidad = 0 ;
                }
            });
            this.$emit('update');
        },
        searchElemento(date){
            let result = null;
            this.elementos.forEach(element => {
       
                if(element.fecha.isSame(date,'date')){
                    result = element;
                };
            });
            return result;
        },
        NextMonday(){

            this.currentDate = this.currentDate.add(1,'month');
             this.getDates();
  
        },
        PreviousMonday(){
            this.currentDate.subtract(1,'month');
 this.getDates();
        },
        getMonday() {
            this.getDates();
        },

        getDates() {
            var dateArray = new Array();
            var currentDate = moment(this.currentDate.toString());
            while(currentDate.format('ddd') != "Mon"){
                currentDate.subtract(1,'days');
            }
            for (let i = 0; i < this.dias.length; i++) {
                this.dias[i].fecha = moment(currentDate.toString());
                currentDate = currentDate.add(1, "days");
            }
            this.updateElementos();
        },
    },
    mounted() {
        this.getMonday();
    },
};
</script>
<style scoped>
.picker-header-arrow {
    color: gray;
    width: 2rem;
}
.picker-header {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    padding:1rem;
}
.amountNumber {
    color: white;
}
.iconbutton {
    color: white;
    width: 1rem;
    height: 1rem;
}
.addbutton {
    padding: 0.25rem;
    display: flex;
    text-align: center;
    flex: 1;
    justify-content: center;
}
.amountButton {
    min-width: none;
    display: flex;
    margin-top: 0.75rem;
    margin-bottom: 0.75rem;
    align-items: center;
    justify-content: center;
    border-radius: 1rem;
    background-color: #1e1e1e;
    min-width: 85%;
    min-height: 2rem;
}
.amountButton-0 {
    min-width: none;
    display: flex;
    margin-top: 0.75rem;
    margin-bottom: 0.75rem;
    align-items: center;
    justify-content: center;
    border-radius: 1rem;
    background-color: #8a8a8a;
    min-width: 85%;
    min-height: 2rem;
}
.numero {
    border-radius: 1rem;
    background-color: rgb(224, 224, 224);
    min-width: 75%;
}
.dia {
    font-weight: bold;
    font-family: "Roboto", sans-serif !important;
    min-width: 100%;
    text-align: center;
    padding-top: 0.75rem;
    padding-bottom: 0.75rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
@media only screen and (max-width: 800px) {
    .amountButton {
        flex-direction: column-reverse;
    }
}
.separator {
}
</style>
