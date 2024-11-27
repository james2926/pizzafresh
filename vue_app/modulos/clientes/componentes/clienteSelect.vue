<template>
    <v-autocomplete
    dense outlined
        @update:search-input="SearchCliente"
        v-model="id_cliente"
        :items="clientes"
        :item-text="itemText"
        item-value="id"
        :label="label"
    >
        <template v-slot:append-item>
            <div v-intersect="endIntersect" />
        </template>
    </v-autocomplete>
</template>
<script>
import { debounce } from "../../../helpers";

export default {
    props: ["value", "extra", "label", "item-text"],
    data() {
        return {
            id_cliente: null,
        };
    },
    watch: {
        value(val) {
            this.id_cliente = val;
        },
        id_cliente(val) {
            this.$emit("input", val);
        },
    },
    methods: {
        SearchCliente: debounce(function (val) {
            this.$store.dispatch("searchCliente", val);
        }, 500),
        endIntersect(entries, observer, isIntersecting) {
            if (isIntersecting) {
                this.$store.dispatch("getClientesNext", this);
            }
        },
    },
    mounted() {
        console.log("aqui");
        this.$store.dispatch("getClientes", this);
    },
    computed: {
        clientes() {
            ///console.log("siva");
            let clientes_temp = this.$store.getters.getclientes;
            if (this.extra) {
                clientes_temp.push(this.extra);
            }
            return clientes_temp;
        },
    },
};
</script>
