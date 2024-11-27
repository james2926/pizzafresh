<template>
    <div>
        <loader v-if="isloading"></loader>
        <v-card shaped class="mx-4 my-4 pa-4">
            <v-card-title>
                <v-toolbar flat color="#1d2735" dark style="border-radius: 5px">
                    <v-icon class="white--text" style="font-size: 45px"
                        >mdi-account-supervisor-circle</v-icon
                    >
                    <pre><v-toolbar-title><h2>Control de pedidos</h2></v-toolbar-title></pre>
                </v-toolbar>
            </v-card-title>
            <v-card-text>
                <v-form class="mt-3">
                    <v-row justify="space-between" class="mb-3">
                        <v-col cols="12" sm="4" md="4">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        icon
                                        color="primary"
                                        large
                                        v-bind="attrs"
                                        v-on="on"
                                        @click="getControl('anteror')"
                                    >
                                        <v-icon
                                            >mdi-arrow-left-bold-circle-outline</v-icon
                                        >
                                    </v-btn>
                                </template>
                                <span>Dia anterior</span>
                            </v-tooltip>
                        </v-col>
                        <v-col cols="12" sm="4" md="4">
                            <div class="d-flex justify-center">
                                Fecha: {{ fecha_formateada }}
                            </div>
                            <div class="d-flex justify-center">
                                Lote: {{ getBatch(fecha_formateada) }}
                            </div>
                            <div class="d-flex justify-center">
                                Caducidad: {{ getExpireDate(fecha_formateada) }}
                            </div>
                        </v-col>
                        <v-col
                            cols="12"
                            sm="4"
                            md="4"
                            class="d-flex justify-end"
                        >
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn
                                        icon
                                        color="primary"
                                        large
                                        v-bind="attrs"
                                        v-on="on"
                                        @click="getControl('siguiente')"
                                    >
                                        <v-icon
                                            >mdi-arrow-right-bold-circle-outline</v-icon
                                        >
                                    </v-btn>
                                </template>
                                <span>Dia siguiente</span>
                            </v-tooltip>
                        </v-col>
                    </v-row>

                    <!-- Orden de fabricacion -->
                    <div style="padding-bottom: 2rem">
                        <h1>Orden de Fabricación</h1>
                    </div>

                    <div
                        class="box-shadow sticky-card"
                        style="
                            overflow-x: auto;
                            border-radius: 4px;
                            padding-bottom: 0.5rem;
                        "
                    >
                        <table
                            style="
                                min-width: 100%;
                                border-collapse: collapse;
                                border-spacing: 0;
                            "
                        >
                            <tr class="t-header">
                                <th class="t-header-items">Articulo</th>
                                <th
                                    class="t-header-items align-center truncate-text"
                                    v-for="item in orden.articulos"
                                >
                                    {{ item.articulo.nombre | formatArticuloTitle }}
                                </th>
                            </tr>
                            <!-- <tr v-if="orden.urgencia == 0">
                                <th class="t-header-items align-left">
                                    Inventario Inicial
                                </th>
                                <td v-for="item in orden.articulos">
                                    <v-text-field
                                        class="my-1"
                                        outlined
                                        :value="0"
                                        v-model="item.inventario_inicial"
                                        dense
                                        hide-details
                                    ></v-text-field>
                                </td>
                            </tr> -->
                            <tr>
                                <th class="t-header-items align-left">
                                    Inventario final
                                </th>
                                <td v-for="item in orden.articulos">
                                    <!-- <span>{{
                                        item.total_fabricar
                                    }}</span> -->
                                    <v-text-field
                                        class="my-1"
                                        outlined
                                        dense
                                        v-model="item.total_fabricar"
                                        hide-details
                                    ></v-text-field>
                                </td>
                            </tr>
                            <!-- <tr>
                                <th class="t-header-items align-left">
                                    Inventario total
                                </th>
                                <td v-for="item in orden.articulos">
                                    <span>
                                        {{
                                            item.inventario_inicial > 0 
                                                ? (parseFloat(item.inventario_inicial) + parseFloat(item.total_fabricar))
                                                : (parseFloat(item.inventario_inicial_original) + parseFloat(item.total_fabricar))
                                        }}
                                    </span>
                                </td>
                            </tr> -->
                            <tr>
                                <th class="t-header-items align-left">
                                    Ventas diarias
                                </th>
                                <td v-for="item in orden.articulos">
                                    <template v-for="item2 in ventas_diarias">
                                        <span
                                            v-if="
                                                item.articulo.nombre ==
                                                item2.bola
                                            "
                                        >
                                            {{ item2.venta }}
                                        </span>
                                    </template>
                                </td>
                            </tr>
                            <!-- <tr>
                                <th class="t-header-items align-left">
                                    Total de Torres a Fabricar
                                </th>
                                <td v-for="item in orden.articulos">
                                    {{ TorreFormat(item) }}
                                </td>
                            </tr> -->
                            <tr>
                                <th class="t-header-items align-left">Resto</th>
                                <td
                                    v-for="item in orden.articulos"
                                    :key="item.articulo.nombre"
                                >
                                    <template v-for="item2 in ventas_diarias">
                                        <span
                                            v-if="item.articulo.nombre == item2.bola"
                                            :class="{
                                                'text-red' : calcularStock(item.inventario_inicial, item.total_fabricar, item2.venta, item.inventario_inicial_original) < 100
                                            }"
                                        >
                                            {{ calcularStock(item.inventario_inicial, item.total_fabricar, item2.venta, item.inventario_inicial_original) }}
                                        </span>
                                    </template>
                                </td>
                            </tr>
                        </table>
                        <!-- <v-col cols="12">
                            <v-textarea
                                dense
                                outlined
                                label="Observaciones"
                                v-model="orden.observaciones"
                            ></v-textarea>
                        </v-col> -->
                    </div>

                    <div class="d-flex justify-end mt-2">
                        <v-btn
                            @click="changeInventarios()"
                            :disabled="isloading"
                            color="success"
                            class="white--text"
                            >Actualizar Inventarios</v-btn
                        >
                    </div>

                    <!-- Indicadores -->
                    <div>
                        <div>
                            <span>Total de bolas: {{getTotalBolas()}}</span>
                        </div>
                        <div>
                            <span>Ventas totales: {{ total_und_dia }}</span>
                        </div>
                    </div>

                    <!-- Empqueatdo -->
                    <div class="d-flex justify-space-between" style="padding: 2rem 0">
                        <div class="d-flex align-items">
                            <h1 style="margin-top: 5px;">Empaquetado</h1>
                            <v-icon color="info" class="pointer ml-3" @click="alert = true">mdi-information</v-icon>
                        </div>
                        <v-btn
                            :disabled="isloading"
                            color="success"
                            class="white--text"
                            @click="openDialog()"
                        >
                            Nuevo pedido
                        </v-btn>
                    </div>
                    <v-alert 
                        v-model="alert" 
                        dismissible 
                        type="info" 
                        border="top"
                        colored-border
                        elevation="2"
                    >
                        Puede actualizar la cantidad del pedido dando doble click sobre 
                        el producto que desee y presionar la tecla enter
                    </v-alert>
                    <div>
                        <v-data-table
                            :item-class="row_classes"
                            dense
                            :headers="headers"
                            :items="pedidos"
                            :items-per-page="-1"
                            item-key="id"
                            class="elevation-1"
                            :sort-by="['cliente.tipo_cliente.id']"
                            :sort-desc="[false]"
                            :expand-on-click="true"
                            :group-by="groupBy"
                        >
                            <!-- <template v-slot:header>
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-right">
                                            Total por tipo de pizza
                                        </th>
                                        <th></th>
                                        <th
                                            v-for="(item, index) in prependHeader"
                                            :key="index"
                                        >
                                            {{ item.value }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-right">
                                            Total unidades por dia
                                        </th>
                                        <th>{{ total_und_dia }}</th>
                                        <th :colspan="prependHeader.length"></th>
                                    </tr>
                                </thead>
                            </template> -->
                            <!-- <template v-slot:[`item.cliente.nombre_fiscal`]="{ item }">
                                <td 
                                    v-if="item.cliente.id_tipo_cliente !== null"
                                    :style="{
                                        backgroundColor: getBackgroundColor(item.cliente.id_tipo_cliente),
                                        color: 'white',
                                    }"
                                    class="truncate-text"
                                >
                                    {{ item.cliente.nombre_fiscal }}
                                </td>
                                <td class="truncate-text" v-else>
                                    {{ item.cliente.nombre_fiscal }}
                                </td>
                            </template> -->
                            <template v-slot:group.header="{ items, group }">
                                <td :colspan="headers.length" class="group-header">
                                    <h4 class="my-2">
                                        {{items[0].cliente.tipo_cliente != null ? items[0].cliente.tipo_cliente.descripcion : '' }}
                                    </h4>
                                </td>
                            </template>

                            <template v-slot:item="{ item }">
                                <tr>
                                    <!-- cliente -->
                                    <td 
                                        v-if="item.cliente.id_tipo_cliente !== null"
                                        :style="{
                                            backgroundColor: getBackgroundColor(item.cliente.id_tipo_cliente),
                                            color: 'white',
                                        }"
                                        class="truncate-text"
                                    >
                                        {{ item.cliente.nombre_fiscal }}
                                    </td>
                                    <td class="truncate-text" v-else>
                                        {{ item.cliente.nombre_fiscal }}
                                    </td>
                                    
                                    <td>{{ item.cliente.codigo_envio }}</td>
                                    <td>{{ item.total_cajas }}</td>
                                    <td>{{ item.total_cantidad }}</td>
                                    <td
                                        v-for="(header, index) in headers"
                                        :key="index"
                                        @click="handleCellClick($event, item, header.value, header.id)"
                                        v-if="index > 3"
                                    >
                                        <template v-if="isEditing(item, header.value)">
                                            <input
                                                type="text"
                                                style="width: 50px"
                                                v-model="editingValue"
                                                @keyup.enter="saveEdit(item, header.value, header.id)"
                                            />
                                        </template>
                                        <template v-else>
                                                {{ item[header.value] }}
                                        </template>
                                    </td>
                                    <!-- <td v-for="(header, index) in headers" :key="index" @click="handleCellClick($event, item, header.value)">
                                        {{ item[header.value] }}
                                    </td> -->
                                </tr>
                            </template>
                        </v-data-table>
                    </div>
                </v-form>
            </v-card-text>
        </v-card>

        <!-- Crear pedido -->
        <v-dialog v-model="dialog" max-width="1000px">
            <v-card>
                <v-card-title
                    class="text-h5 aviso"
                    style="
                        justify-content: center;
                        background: #1d2735;
                        color: white;
                    "
                >
                    Nuevo Pedido
                </v-card-title>
                <v-card-text style="text-align: center; padding-top: 1rem">
                    <v-row>
                        <v-col cols="12" md="3">
                            <date-select
                                v-model="pedido.fecha_empaquetado"
                                label="Fecha de Fabricacion"
                            >
                            </date-select>
                        </v-col>
                        <v-col cols="12" md="3">
                            <!-- <cliente-select
                                label="Cliente"
                                item-text="nombre_fiscal"
                            >
                            </cliente-select> -->
                            <select-cliente
                                label="Cliente"
                                item-text="nombre_fiscal"
                                v-model="pedido.id_cliente"
                                :extra="pedido.cliente"
                            >
                            </select-cliente>
                        </v-col>
                        <v-col cols="12" md="3">
                            <v-text-field-outlined
                                v-model="pedido.gastos_envio"
                                label="Gastos Envio"
                                required
                            ></v-text-field-outlined>
                        </v-col>
                        <v-col cols="12" md="3">
                            <v-text-field-outlined
                                label="Descuento"
                                v-model="pedido.descuento"
                                required
                            ></v-text-field-outlined>
                        </v-col>
                    </v-row>
                    <lista-items v-model="pedido.items"></lista-items>
                </v-card-text>
                <v-card-actions class="pt-3">
                    <v-spacer></v-spacer>
                    <v-btn color="error" large @click="dialog = false"
                        >Cancelar</v-btn
                    >
                    <v-btn color="success" large @click="savepedido"
                        >Guardar</v-btn
                    >

                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<style>
    .text-red {
        color: red;
    }
    .t-header {
    min-width: 100%;
    background-color: rgb(29, 39, 53);
    text-align: left;
    color: white;
    /* padding: 1rem; */
    }
    .align-center {
        text-align: center;
        vertical-align: center;
    }
    .align-left {
        text-align: left;
        vertical-align: center;
        display: flex;
        align-items: center;
    }
    .box-shadow {
        box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
            0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12) !important;
    }
    .cliente-column {
    width: 100px;
    white-space: nowrap;
    overflow: hidden; 
    text-overflow: ellipsis;
    }
    .truncate-text {
    white-space: nowrap;        /* Evita el salto de línea */
    overflow: hidden;           /* Oculta el texto que excede el ancho */
    text-overflow: ellipsis;    /* Muestra los puntos suspensivos */
    }
</style>
<style scoped>
.sticky-card {
    position: sticky;
    top: 0;
    background-color: white; /* Ensures the sticky card is not transparent */
    z-index: 5; /* Keeps the sticky card above other content */
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1); /* Optional: Add a subtle shadow */
}
.t-header-items {
    width: 130px;
    /* padding: 0.5rem; */
}
</style>

<script>
import moment from "moment";
import SelectCliente from "../../clientes/componentes/clienteSelect.vue";
import DateSelect from '../../../components/general/dateSelect.vue';
import ListaItems from './ListaItems.vue';
export default {
  components: { SelectCliente, DateSelect, ListaItems },
    data() {
        return {
            orden: {
                fecha: null,
                articulos: [],
                pedidos: [],
                urgencia: 0,
            },
            pedido: {
                id: null,
                email: "",
                password: "",
                id_role: -1,
                nombre: null,
                fecha_empaquetado: '',
            },
            constante: {
                incremento_inv: null,
                total_gr_masa: null,
                capacidad_max: null,
            },
            headers: [
                // { text: "Ref", value: "id", sortable: false },
                {
                    text: "Cliente",
                    value: "cliente.nombre_fiscal",
                    sortable: false,
                },
                {
                    text: "Código envió",
                    value: "cliente.codigo_envio",
                    sortable: false,
                },
                {
                    text: "Total Pedido",
                    value: "total_cajas",
                    sortable: false,
                },
            ],
            pedidos: [],
            groupBy: 'cliente.tipo_cliente.id',
            dialog: false,
            updateItemDialog: false,
            updatedValue: 0,
            prependHeader: [],
            showTipoColumn: true,
            total_und_dia: 0,
            cliente: [],
            ventas_diarias: [],
            fecha_empaquetado: '',
            fecha: moment().format("YYYY-MM-DD").substring(0, 10),
            selectedData: {},
            selected_id: 0,
            editingItem: null,
            editingHeader: null,
            editingValue: '',
            editingFlag: false,
            alert: true,
            defaultInitial: 0,
        };
    },
    created() {
        this.getConstantes();
        this.getHeaders();
        this.generarOrden();
        this.getControl(null);
    },
    methods: {
        getBackgroundColor(id_tipo_cliente) {
            if (id_tipo_cliente === 1) {
                return "#2196f3";
            } else if (id_tipo_cliente === 2) {
                return "#9c27b0";
            } else if (id_tipo_cliente === 3) {
                return "#f44336";
            } else if (id_tipo_cliente === 4) {
                return "#ff9800";
            } else {
                return "";
            }
        },
        getBatch(fecha_formateada) {
            let date = moment(fecha_formateada, 'DD-MM-YYYY');
            let weekOfYear = date.week();
            return weekOfYear+"/"+date.format('DD/MM/YYYY');
        },
        getExpireDate(fecha_formateada) {
            let date = moment(fecha_formateada, 'DD-MM-YYYY');
            let expireDate = date.add(20, 'days');

            return expireDate.format('DD/MM/YYYY');
        },
        getTotalBolas() {
            let total_bolas = 0;
            this.orden.articulos.map((item, index) => {
                total_bolas += parseFloat(item.total_fabricar);
            })
            return total_bolas;
        },
        handleCellClick(event, item, headerValue, articulo_id) {            
            let currentValue = event.target.value;

            const data = {
                articulo_id: articulo_id,
                id: item.id,
            }

            axios
                .get("api/exist-pedido-item", { params: data })
                .then((res) => {
                    if(res.data.result) {
                        this.editingFlag = true;
                    } else {
                        this.editingFlag = false;
                    }
                })
                .catch((error) => {
                    console.error('error');
                })

            console.log('currentValue', currentValue);
                
            if(currentValue != undefined) { 
                let cantidad = 0;  
                if(currentValue.includes('/')){
                    const parcial = currentValue.split('/');
                    cantidad = parcial[1];
                }else{
                    cantidad = currentValue;
                }

                // console.log('cantidad', cantidad);
                
                item.items.map((element, index) => {                    
                    // console.log(index, " ==> ", element);
                    if(element.cantidad * element.articulo.unidades_caja == cantidad) {
                        console.log("id ==> ", element.id);
                        this.selected_id = element.id;
                    }
                });
                console.log('selected_id', this.selected_id);
            }
            this.editingItem = item;
            this.editingHeader = headerValue;
            this.editingValue = item[headerValue];
        },
        isEditing(item, headerValue) {
            return this.editingItem === item && this.editingHeader === headerValue;
        },
        saveEdit(item, headerValue, articulo_id) {
            this.updatedValue = this.editingValue;

            // Verifica si se necesita actualizar o guardar un nuevo pedido
            if(this.editingFlag) {
                this.updatePedidoItem(articulo_id);
            } else {
                const data = {
                    id: item.id,
                    articulo_id: articulo_id,
                    cantidad: this.editingValue,
                }

                axios
                    .post("api/save-pedido-item", data)
                    .then((res) => {
                        if(res.data.status == 'success') {
                            this.getControl(null);
                            this.editingFlag = false;
                            this.$toast.sucs('Actualización de pedido con exito')
                        }
                    })
                    .catch((error) => {
                        console.error('error');
                    })
            }

            // Resetea las variables después de completar la edición
            this.editingItem = null;
            this.editingHeader = null;
            this.editingValue = '';
        },
        updatePedidoItem(articulo_id) {
            this.selectedData = {
                id: this.selected_id,
                value: this.editingValue,
                articulo_id: articulo_id,
            }

            if(this.updatedValue !== 0) {
                axios
                    .post("api/update-pedido-item", this.selectedData)
                    .then((res) => {
                        if(res.data.status == 'success') {
                            this.updateItemDialog = false;
                            this.getControl(null);
                            this.editingFlag = false;
                            this.$toast.sucs('Actualización de pedido con exito')
                        }                     
                    })
                    .catch((error) => {
                        console.error('error');
                    })
            }
        },
        savepedido() {
            axios
                .post("api/save-pedido", this.pedido)
                .then((res) => {
                    this.dialog = false;
                    this.getControl(null);
                })
                .catch((error) => {
                    if (error.response.status == 400) {
                        this.$custom_error(
                            "Ingrese Todos los datos correctamente"
                        );
                    } else {
                        this.$custom_error("Algo salio mal");
                    }
                });
        },
        getConstantes() {
            axios.get("api/get-constantes").then((res) => {
                this.constante = res.data;
            });
        },
        getHeaders() {
            // axios.get(`api/get-headers-produccion`).then(
            axios.get(`api/get-headers-control-pedidos`).then(
                (res) => {
                    this.headers = res.data;
                },
                (err) => {
                    this.$custom_error("Error consultando Articulo");
                }
            );
        },
        openDialog() {
            this.dialog = true;
        },
        getControl(string) {
            if (string != null) {
                if (string == "siguiente") {
                    this.fecha = moment(this.fecha)
                        .add(1, "days")
                        .format("YYYY-MM-DD")
                        .substring(0, 10);
                } else {
                    this.fecha = moment(this.fecha)
                        .subtract(1, "days")
                        .format("YYYY-MM-DD")
                        .substring(0, 10);
                }
            }
            axios.get(`api/get-control-pedidos?fecha=${this.fecha}`).then(
                (res) => {
                    this.orden = res.data.success.fabricacion ?? {};
                    this.pedidos = res.data.success.pedidos;
                    this.ventas_diarias = res.data.success.ventas_diarias;
                    this.setPrependHeader();
                    // this.setInventarioinicial();
                    this.calculateTotalUndDia();
                    // this.calcularTotalTorres();
                },
                (err) => {
                    this.$custom_error("Error consultando Articulo");
                }
            );
        },
        setInventarioinicial(){
            this.orden.articulos?.forEach((element) => {
                element.inventario_inicial_original = element.inventario_inicial; // Guarda el valor original
                element.inventario_inicial = 0;
            })
        },
        generarOrden() {
            axios.post(`api/generate-produccion`).then(
                (res) => {
                    // this.orden = res.data;
                },
                (err) => {
                    this.$custom_error("Error consultando Articulo");
                }
            );
        },
        changeInventarios() {
            axios.post(`api/change-inventarios`, this.orden).then(
                (res) => {
                    this.$toast.sucs(res.data.success);
                },
                (err) => {
                    this.$custom_error("Error consultando Articulo");
                }
            );
        },
        calcularTotalTorres() {
            let total_torres = 0;
            if (this.orden.articulos.length > 0) {
                this.orden.articulos.forEach((element2) => {
                    let torres = this.Torre(element2);
                    const separados = torres.toFixed(0);

                    const cajas =
                        element2.total_fabricar /
                            element2.articulo.unidades_caja -
                        parseInt(separados) * element2.articulo.unidades_torre;

                    const cajas_redondeadas = cajas.toFixed(2);
                    total_torres +=
                        parseFloat(separados) + parseFloat(cajas_redondeadas);
                });
            }

            this.total_torres = total_torres;
        },
        TorreFormat(item) {
            let torres = this.Torre(item);
            const separados = torres.toFixed(0);
            const cajas =
                item.total_fabricar / item.articulo.unidades_caja -
                parseInt(separados) * item.articulo.unidades_torre;
            return `${separados} ${
                cajas > 0 ? `y ${cajas.toFixed(2)} cajas` : ""
            }`;
        },
        Torre(item) {
            return this.Caja(item) / item.articulo.unidades_torre;
        },
        Caja(item) {
            return item.total_fabricar / item.articulo.unidades_caja;
        },
        row_classes(item) {
            // if (item.pedido.id_estado == 2) {
            if (item.id_estado == 2) {
                return "bg-green";
            }
            // if (item.pedido.id_estado == 3 || item.pedido.id_estado == 4) {
            if (item.id_estado == 3 || item.id_estado == 4) {
                return "bg-yellow";
            }
            return "";
        },
        setPrependHeader() {
            this.prependHeader = [];
            let nuevoHeader = this.headers.slice(4);
            nuevoHeader.forEach((header) => {
                const key = header.value;

                // Calcula la suma de la columna 'key'
                let sumaCantidad = 0;
                this.pedidos.forEach((pedido) => {
                    if (pedido[key] != undefined) {
                        let valor = pedido[key];
                        // Si el valor es una fracción en formato "x/y"
                        if (typeof valor === "string" && valor.includes("/")) {
                            let [numerador, denominador] = valor
                                .split("/")
                                .map(Number);
                            // Divide el número en dos y resta los resultados
                            valor = denominador - numerador;
                        }
                        sumaCantidad += valor;
                    }
                });
                this.prependHeader.push({ text: key, value: sumaCantidad });
            });
        },
        calculateTotalUndDia() {
            this.ventas_diarias.forEach((element) => {
                this.total_und_dia += element.venta;
            });
        },
        calcularStock(inventarioInicial, totalFabricar, venta, inventarioInicialOriginal) {
            // Asegúrate de que los valores son números
            const inicialOriginal = Number(inventarioInicialOriginal) || 0;
            const inicial = Number(inventarioInicial) || 0;
            const fabricar = Number(totalFabricar) || 0;
            const ventaNum = Number(venta) || 0;

            const inventario = inicial > 0 ? inicial : inicialOriginal;

            // Realiza el cálculo
            return inventario + fabricar - ventaNum;
        },
    },
    watch: {},
    computed: {
        isloading() {
            return this.$store.getters.getloading;
        },
        fecha_formateada() {
            console.log(this.fecha);
            return moment(this.fecha).format("DD/MM/YYYY");
        },

        computedHeaders() {
            // Filter out the Age column if showAgeColumn is false
            return this.showTipoColumn
            ? this.headers
            : this.headers.filter(header => header.value !== 'id_tipo_cliente');
        }
    },
};
</script>
