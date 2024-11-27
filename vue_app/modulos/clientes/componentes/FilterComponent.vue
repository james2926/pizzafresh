<template>
    <v-container>
        <v-row>
            <v-col cols="10">
                <v-text-field
                    outlined
                    v-model="result.search"
                    label="Busqueda"
                ></v-text-field>
            </v-col>
            <v-col cols="2">
                <v-menu :location="location" :close-on-content-click="false">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn color="primary" dark v-bind="attrs" v-on="on">
                            <v-icon>mdi-filter</v-icon>
                        </v-btn>
                    </template>

                    <v-list style="min-width: 20rem">
                        <v-list-item
                            v-for="(item, index) in headers"
                            :key="index"
                        >
                            <div
                                style="
                                    display: flex;
                                    flex-direction: column;
                                    width: 100%;
                                    padding-top: 0.25rem;
                                "
                            >
                                <div
                                    @click="activarItem(item)"
                                    style="
                                        display: flex;
                                        cursor: pointer;
                                        justify-content: space-between;
                                        flex-direction: row;
                                        width: 100%;
                                    "
                                >
                                    <div>{{ item.title }}</div>
                                    <div style="flex: 1"></div>
                                    <svg
                                        :class="`icon ${
                                            item.active ? 'upside-down' : ''
                                        }`"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        style="width: 1rem; height: 1rem"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                                        />
                                    </svg>
                                </div>

                                <div
                                    :class="`menu ${
                                        item.active ? 'active' : ''
                                    }`"
                                    v-if="item.item != null"
                                >
                                    <div v-if="item.type == 'date'">
                                        <v-select
                                            :value="item.item.tipo"
                                            @input="
                                                (val) => {
                                                    updateTipo(item.item, val);
                                                }
                                            "
                                            label="tipo"
                                            :items="opciones_fecha"
                                        ></v-select>
                                        <date-select
                                            v-model="result[item.model].start"
                                            v-if="item.item.tipo != 2"
                                            label="Desde"
                                        >
                                        </date-select>
                                        <date-select
                                            v-model="result[item.model].end"
                                            v-if="item.item.tipo != 1"
                                            label="Hasta"
                                        >
                                        </date-select>
                                    </div>
                                    <div v-else-if="item.type == 'select'">
                                        <v-select
                                            v-model="result[item.model].value"
                                            :label="multiple ? 'Seleccione una o mas opciones' : 'Seleecione uno'"
                                            value="item.items.value"
                                            :items="item.items"
                                            :multiple = "multiple"
                                        ></v-select>
                                    </div>
                                    <div v-else>
                                        <v-text-field
                                            v-model="result[item.model].value"
                                            :item-text="
                                                item.item_text == null
                                                    ? 'nombre'
                                                    : item.item_text
                                            "
                                            :item-value="
                                                item.item_value == null
                                                    ? 'id'
                                                    : item.item_value
                                            "
                                            label="Busqueda"
                                        ></v-text-field>
                                    </div>
                                </div>
                            </div>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-col>
            <v-col cols="12">
                <div style="width: 100%; display: flex; flex-wrap: wrap">
                    <template v-for="key in Object.keys(result)">
                        <template v-if="result[key]">
                            <v-chip
                                style="margin-bottom: 0.25rem"
                                v-if="
                                    (result[key].value != '') &
                                        (result[key].value != null) ||
                                    (result[key].start != '') &
                                        (result[key].start != null) ||
                                    (result[key].end != '') &
                                        (result[key].end != null)
                                "
                            >
                                <div style="display: flex; align-items: center">
                                    <div style="padding-right: 1rem">
                                        {{ key }}, {{ result[key].value
                                        }}{{ result[key].start }} -
                                        {{ result[key].end }}
                                    </div>
                                    <div
                                        style="
                                            cursor: pointer;
                                            display: flex;
                                            align-items: center;
                                        "
                                        @click="deleteItem(key)"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="2"
                                            stroke="currentColor"
                                            class="icon"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12"
                                            />
                                        </svg>
                                    </div>
                                </div>
                            </v-chip>
                        </template>
                    </template>
                </div>
            </v-col>
        </v-row>
    </v-container>
</template>
<style>
.menu {
    overflow: hidden;
    max-height: 0px;
    transition: max-height 0.3s;
}

.menu.active {
    display: block;
    max-height: 200px;
}
.icon {
    width: 1rem;
    height: 1rem;
    transition: transform 0.3s;
}

.icon.upside-down {
    transform: rotate(180deg);
}
</style>
<script>
export default {
    props: ["value", "headers", "multiple"],
    created() {
        this.result = this.value ?? {};
        this.checkItems();
    },
    data() {
        return {
            dialog: false,
            result: {},
            opciones_fecha: [
                { value: 1, text: "Desde" },
                { value: 2, text: "Hasta" },
                { value: 3, text: "Entre" },
            ],

            locations: ["top", "bottom", "start", "end", "center"],
            location: "end",
        };
    },
    watch: {
        value: {
            deep: true,
            handler(val) {
                this.result = val ?? {};
                this.checkItems();
            },
        },
        result: {
            deep: true,
            handler(val) {
                this.$emit("input", val);
            },
        },
    },
    methods: {
        deleteItem(key) {
            this.result[key].value = "";
            this.result[key].start = "";
            this.result[key].end = "";
        },
        updateTipo(model, value) {
            model.tipo = value;
            const resultado = JSON.stringify(this.result);
            this.result = [];
            this.result = JSON.parse(resultado);
        },
        checkItems() {
            let changed = false;
            this.headers.forEach((element) => {
                if (this.result[element.model ?? element.title] == null) {
                    this.result[element.model ?? element.title] = { tipo: 1 };
                    changed = true;
                    if (element.type == "date") {
                        this.result[element.model ?? element.title].end = "";
                        this.result[element.model ?? element.title].start = "";
                    } else {
                        this.result[element.model ?? element.title].value = "";
                    }
                }
                element.item = this.result[element.model ?? element.title];
            });
            if (changed) this.result = JSON.parse(JSON.stringify(this.result));
        },
        activarItem(_item) {
            this.headers.forEach((item) => {
                if (item == _item) {
                    item.active = !item.active;
                } else {
                    item.active = false;
                }
            });
        },
    },
};
</script>
