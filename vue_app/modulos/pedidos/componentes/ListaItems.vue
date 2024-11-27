<template>
    <v-row>
        <v-col cols="12">
            <v-btn white-text color="primary" @click="openDialog(false)"
                >Agregar Item</v-btn
            >
        </v-col>
        <v-col>
            <v-data-table :items="items" :headers="headers">
                <template v-slot:item.precio="{ item }">
                    {{ item.precio | format_number }}
                </template>
                <template v-slot:item.subtotal="{ item }">
                    {{ (item.cantidad * item.precio) | format_number }}
                </template>
                <template v-slot:item.action="{ item }">
                    <v-icon
                        @click="openDialog(item)"
                        small
                        class="mr-2"
                        color="#1d2735"
                        style="font-size: 25px"
                        title="EDITAR"
                        >mdi-pencil-outline</v-icon
                    >

                    <v-icon
                        @click="Delete(item)"
                        small
                        class="mr-2"
                        color="red"
                        style="font-size: 25px"
                        title="BORRAR"
                        >mdi-trash-can</v-icon
                    >
                </template>
            </v-data-table>
        </v-col>
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
                    Añadir/Editar Item
                </v-card-title>
                <v-card-text style="text-align: center; padding-top: 1rem">
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-autocomplete
                                v-model="item.id_articulo"
                                label="Articulo"
                                dense
                                outlined
                                item-text="nombre"
                                item-value="id"
                                :items="Articulos"
                            ></v-autocomplete>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field
                                dense
                                outlined
                                v-model="item.cantidad"
                                label="Cantidad (cajas)"
                                type="number"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-switch
                                label="Sin Inventario"
                                v-model="item.sin_stock"
                            ></v-switch>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions class="pt-3">
                    <v-spacer></v-spacer>
                    <v-btn color="error" large @click="dialog = false"
                        >Cancelar</v-btn
                    >
                    <v-btn
                        v-if="index_selected != null"
                        color="success"
                        large
                        @click="update()"
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
</template>
<script>
export default {
    props: ["value"],
    data() {
        return {
            headers: [
                { text: "Ref", value: "articulo.nombre", sortable: false },
                { text: "Cantidad (cajas)", value: "cantidad", sortable: false },
                { text: "Precio", value: "precio", sortable: false },
                { text: "Subtotal", value: "subtotal", sortable: false },
                { text: "Acciones", value: "action", sortable: false },
            ],
            dialog: false,
            index_selected: null,
            item: {},
            Articulos: [],
            items: [],
        };
    },
    mounted() {
        if (this.value) {
            this.items = this.value;
        }
        this.getArticulos();
    },
    watch: {
        value: {
            deep: true,
            handler: function (val) {
                if (val) {
                    this.items = val;
                } else {
                    this.items = [];
                }
            },
        },
        items: {
            deep: true,
            handler: function (val) {
                console.log(val);
                this.$emit("input", val);
            },
        },
    },
    methods: {
        Delete(item) {
            let index = this.items.indexOf(item);
            this.items = this.items.splice(index, 1);
        },
        putArticulo() {
            let articulo = this.Articulos.find(
                (element) => element.id == this.item.id_articulo
            );
            this.item.articulo = articulo;
            this.item.precio = articulo.precio;
        },
        update() {
            if (this.index_selected != null) {
                this.putArticulo();
                this.items[this.index_selected] = this.item;
                this.items.push({});
                this.items = this.items.splice(this.items.length - 1, 1);
                this.item = {};
            }
            this.dialog = false;
        },
        create() {
            if (this.index_selected) {
                this.update();
            } else {
                this.putArticulo();

                this.items.push(this.item);
                console.log(this.items);
                this.item = {};
                this.dialog = false;
            }
        },
        openDialog(item) {
            this.dialog = true;
            if (item) {
                this.index_selected = this.items.indexOf(item);
                console.log(this.index_selected);
                this.item = JSON.parse(JSON.stringify(item));
            } else {
                this.item = {};
                this.index_selected = null;
            }
        },
        getArticulos() {
            axios.get(`api/get-articulos`).then(
                (res) => {
                    this.Articulos = res.data;
                },
                (err) => {
                    this.$custom_error("Error consultando Articulos");
                }
            );
        },
    },
};
</script>
