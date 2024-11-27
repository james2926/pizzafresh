<template>
    <div style="display: flex; flex-direction: column">
        <div class="picker-header">
            <button @click="PreviousMonday">
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
                {{ meses[currentDate.format("M")] }}
            </h2>
            <button @click="NextMonday">
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
        <div
            style="display: flex; align-items: center; justify-content: center"
        >
            <div style="overflow-x: auto">
                <div
                    class="main-container"
                    :style="`grid-template-columns:  repeat(${dias.length}, 3rem);`"
                >
                    <div
                        v-for="dia in dias"
                        :key="dia.fecha"
                        style="
                            display: flex;
                            flex-direction: column;
                            flex: 1;
                            align-items: center;
                            width: 2.5rem;
                        "
                    >
                        <div
                            class="dia"
                            style="border-bottom: 1px solid rgb(216, 216, 216)"
                        >
                            {{ GetDiaCalendar(dia.fecha) }}
                        </div>
                        <div class="dia">
                            <div>{{ dia.nombre }}</div>
                            <div class="numero">
                                {{ dia.fecha.format("D") }}
                            </div>
                        </div>
                    </div>

                    <!--Mostrar planificaciones de Tv-->
                    <div
                        v-if="plan_tv.length > 0"
                        :style="elementoSubtitle(dias.length)"
                    >
                        <h3>TV</h3>
                    </div>
                    <template v-for="plan in plan_tv">
                        <div :style="elementoSubtitle(dias.length)">
                            <h4>{{ plan.matricula }}</h4>
                            <div style="margin-left: 3rem">
                                <router-link
                                    :to="{
                                        path: `/guardar-planificacion?id_plan=${plan.id}`,
                                    }"
                                    class="action-buttons"
                                >
                                    <v-icon
                                        small
                                        class="mr-2"
                                        color="#1d2735"
                                        style="font-size: 25px"
                                        title="EDITAR"
                                        >mdi-pencil-outline</v-icon
                                    >
                                </router-link>
                                <v-icon
                                    @click="openModal(plan.id)"
                                    small
                                    class="mr-2"
                                    color="red"
                                    style="font-size: 25px"
                                    title="BORRAR"
                                    >mdi-trash-can</v-icon
                                >
                                <a
                                    v-if="plan.pdf != null"
                                    :href="`/api/pdf-planificacion/${plan.id}`"
                                >
                                    <v-icon
                                        small
                                        class="mr-2"
                                        color="red"
                                        style="font-size: 25px"
                                        title="PDF"
                                        >mdi-pdf-box</v-icon
                                    >
                                </a>
                            </div>
                        </div>

                        <div :style="elementoSubtitle(dias.length)">
                            <h4>Producto: {{ plan.producto.nombre }}</h4>
                        </div>
                        <div :style="elementoSubtitle(dias.length)">
                            <h4>Observaciones: {{ plan.observaciones }}</h4>
                        </div>
                        <div :style="elementoSubtitle(dias.length)">
                            <h4>Total: {{ plan.total }}</h4>
                        </div>
                        <div v-for="dia in dias">
                            <div
                                :class="
                                    searchElemento(dia.fecha, plan) != 0
                                        ? 'amountButton'
                                        : 'amountButton-0'
                                "
                            >
                                <div class="amountNumber">
                                    {{ searchElemento(dia.fecha, plan) }}
                                </div>
                            </div>
                        </div>
                    </template>
                    <!--Mostrar planificaciones de Radio-->
                    <div
                        v-if="plan_radio.length > 0"
                        :style="elementoSubtitle(dias.length)"
                    >
                        <h3>Radio</h3>
                    </div>
                    <template v-for="plan in plan_radio">
                        <div :style="elementoSubtitle(dias.length)">
                            <h4>{{ plan.matricula }}</h4>
                            <div style="margin-left: 3rem">
                                <router-link
                                    :to="{
                                        path: `/guardar-planificacion?id_plan=${plan.id}`,
                                    }"
                                    class="action-buttons"
                                >
                                    <v-icon
                                        small
                                        class="mr-2"
                                        color="#1d2735"
                                        style="font-size: 25px"
                                        title="EDITAR"
                                        >mdi-pencil-outline</v-icon
                                    >
                                </router-link>
                                <v-icon
                                    @click="openModal(plan.id)"
                                    small
                                    class="mr-2"
                                    color="red"
                                    style="font-size: 25px"
                                    title="BORRAR"
                                    >mdi-trash-can</v-icon
                                >
                                <a
                                    v-if="plan.pdf != null"
                                    :href="`/api/pdf-planificacion/${plan.id}`"
                                >
                                    <v-icon
                                        small
                                        class="mr-2"
                                        color="red"
                                        style="font-size: 25px"
                                        title="PDF"
                                        >mdi-pdf-box</v-icon
                                    >
                                </a>
                            </div>
                        </div>

                        <div :style="elementoSubtitle(dias.length)">
                            <h4>Producto: {{ plan.producto.nombre }}</h4>
                        </div>
                        <div :style="elementoSubtitle(dias.length)">
                            <h4>Observaciones: {{ plan.observaciones }}</h4>
                        </div>
                        <div :style="elementoSubtitle(dias.length)">
                            <h4>Total: {{ plan.total }}</h4>
                        </div>
                        <div v-for="dia in dias">
                            <div
                                :class="
                                    searchElemento(dia.fecha, plan) != 0
                                        ? 'amountButton'
                                        : 'amountButton-0'
                                "
                            >
                                <div class="amountNumber">
                                    {{ searchElemento(dia.fecha, plan) }}
                                </div>
                            </div>
                        </div>
                    </template>
                    <!--Mostrar planificaciones de Web-->
                    <div
                        v-if="plan_web.length > 0"
                        :style="elementoSubtitle(dias.length)"
                    >
                        <h3>Web</h3>
                    </div>
                    <template v-for="plan in plan_web">
                        <div :style="elementoSubtitle(dias.length)">
                            <h4>{{ plan.matricula }}</h4>
                            <div style="margin-left: 3rem">
                                <router-link
                                    :to="{
                                        path: `/guardar-planificacion?id_plan=${plan.id}`,
                                    }"
                                    class="action-buttons"
                                >
                                    <v-icon
                                        small
                                        class="mr-2"
                                        color="#1d2735"
                                        style="font-size: 25px"
                                        title="EDITAR"
                                        >mdi-pencil-outline</v-icon
                                    >
                                </router-link>
                                <v-icon
                                    @click="openModal(plan.id)"
                                    small
                                    class="mr-2"
                                    color="red"
                                    style="font-size: 25px"
                                    title="BORRAR"
                                    >mdi-trash-can</v-icon
                                >
                                <a
                                    v-if="plan.pdf != null"
                                    :href="`/api/pdf-planificacion/${plan.id}`"
                                >
                                    <v-icon
                                        small
                                        class="mr-2"
                                        color="red"
                                        style="font-size: 25px"
                                        title="PDF"
                                        >mdi-pdf-box</v-icon
                                    >
                                </a>
                            </div>
                        </div>
                        <div :style="elementoSubtitle(dias.length)">
                            <h4>Producto: {{ plan.producto.nombre }}</h4>
                        </div>
                        <div :style="elementoSubtitle(dias.length)">
                            <h4>Observaciones: {{ plan.observaciones }}</h4>
                        </div>

                        <div :style="elementoSubtitle(dias.length)">
                            <h4>Total: {{ plan.total }}</h4>
                        </div>
                        <div v-for="dia in dias">
                            <div
                                :class="
                                    searchElemento(dia.fecha, plan) != 0
                                        ? 'amountButton'
                                        : 'amountButton-0'
                                "
                            >
                                <div class="amountNumber">
                                    {{ searchElemento(dia.fecha, plan) }}
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

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
                    Aviso
                </v-card-title>
                <v-card-text style="text-align: center">
                    <h2>¿Estás seguro que deseas eliminar?</h2>
                </v-card-text>
                <v-card-actions class="pt-3">
                    <v-spacer></v-spacer>
                    <v-btn
                        color="error"
                        large
                        @click="
                            dialog = false;
                            selectedItem = null;
                        "
                        >Cancelar</v-btn
                    >
                    <v-btn color="success" large @click="deletePlan()"
                        >Confirmar</v-btn
                    >
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
import moment from "moment";

export default {
    props: ["value", "maxReached"],
    data() {
        return {
            id_plan: null,
            plan_tv: [],
            plan_radio: [],
            plan_web: [],
            dialog: false,
            currentDate: moment().startOf("month"),
            meses: [
                "",
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre",
            ],
            dias_nombres: ["Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
            dias: [],
            elementos: [],
        };
    },
    watch: {
        currentDate() {
            this.getDates();
        },
        elementos() {
            this.$emit("input", this.elementos);
        },
    },

    created() {
        this.elementos = this.value;
    },
    updated() {
        this.elementos = this.value;
    },
    methods: {
        openModal(id) {
            this.id_plan = id;
            this.dialog = true;
        },
        deletePlan() {
            axios
                .post("api/delete-planificacion", {
                    id: this.id_plan,
                })
                .then(
                    (res) => {
                        this.$toast.sucs("Planificacion eliminada");
                        this.dialog = false;
                        window.location.reload();
                    },
                    (err) => {
                        this.$custom_error("Error eliminando Planificacion");
                    }
                );
            this.getClientes();
        },
        elementoSubtitle(cantidad) {
            return `display:flex;justify-content:start;grid-column-start:1;grid-column-end:${
                cantidad + 1
            }`;
        },

        getPlanificaciones() {
            let id = this.$route.query.id;

            axios.get(`api/getplanificaciones/${id}`).then(
                (res) => {
                    this.plan_tv = res.data.plan_tv;
                    this.plan_radio = res.data.plan_radio;
                    this.plan_web = res.data.plan_web;
                },
                (res) => {}
            );
        },
        GetDiaCalendar(date) {
            const dias_nombres = [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa",
                "Do",
            ];
            return dias_nombres[moment(date).day()];
        },

        searchElemento(date, elementos) {
            let result = 0;
            if (Array.isArray(elementos.fecha)) {
                elementos.fecha.forEach((element) => {
                    if (moment(element.fecha).isSame(date, "date")) {
                        result = element.cantidad;
                    }
                });
            } else if (elementos.fecha != null) {
                if (moment(elementos.fecha.fecha).isSame(date, "date")) {
                    result = elementos.fecha.cantidad;
                }
            }

            return result;
        },
        NextMonday() {
            this.currentDate = this.currentDate.add(1, "month");
            this.getDates();
        },
        PreviousMonday() {
            this.currentDate.subtract(1, "month");
            this.getDates();
        },
        getMonday() {
            this.getDates();
        },

        getDates() {
            var start = moment(this.currentDate.toString());
            this.dias = [];
            for (
                var end = moment(start).add(1, "month");
                start.isBefore(end);
                start.add(1, "day")
            ) {
                let dia = { fecha: moment(start.toString()), cantidad: 0 };
                this.dias.push(dia);
            }

            console.log(this.dia);
        },
    },
    mounted() {
        this.getMonday();

        this.getPlanificaciones();
    },
};
</script>
<style scoped>
.main-container {
    display: grid;
    height: 100%;
    min-height: 20rem;

    grid-template-rows: repeat(9, auto) 1fr;
}
.picker-header-arrow {
    color: gray;
    width: 2rem;
}
.picker-header {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    padding: 1rem;
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

    min-height: 2rem;

    flex: 1;

    width: 2.5rem;
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

    min-height: 2rem;

    flex: 1;

    width: 2.5rem;
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
