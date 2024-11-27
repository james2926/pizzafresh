<template>
    <v-list dense nav>
        <v-list-item-group v-model="selectedItem" color="indigo">
            <v-list-item :to="{ path: '/' }">
                <v-list-item-icon>
                    <v-icon color="black">mdi-home</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                    <v-list-item-title class="black--text"
                        >Inicio</v-list-item-title
                    >
                </v-list-item-content>
            </v-list-item>

            <template v-if="$route.path !== '/login'">
                <template v-for="group in groups">
                    <v-list-group
                        v-bind:key="group.key"
                        v-if="group.group"
                        :value="false"
                        :prepend-icon="group.icon"
                    >
                        <template v-slot:activator>
                            <v-list-item-title>{{
                                group.text
                            }}</v-list-item-title>
                        </template>
                        <v-list-item
                            :key="item.path"
                            v-for="item in group.items"
                            :to="{ path: item.path }"
                        >
                            <v-list-item-icon>
                                <v-icon color="black">{{ item.icon }}</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title
                                    class="black--text"
                                    v-html="item.text"
                                ></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-group>

                    <v-list-item
                        v-else
                        :key="item.path"
                        v-for="item in group.items"
                        :to="{ path: item.path }"
                    >
                        <v-list-item-icon>
                            <v-icon color="black">{{ item.icon }}</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title
                                class="black--text"
                                v-html="item.text"
                            ></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </template>
            </template>
        </v-list-item-group>
    </v-list>
</template>

<script>
export default {
    data() {
        return {
            rol: 0,
            selectedItem: null,
            groups: [
                {
                    key: 1,
                    group: false,
                    items: [
                        {
                            path: "/lista-usuario",
                            icon: "mdi-account",
                            text: "Usuarios",
                            auth: false,
                            roles: [1],
                        },
                        {
                            path: "/lista-articulo",
                            icon: "mdi-store",
                            text: "Articulos",
                            auth: false,
                            roles: [1],
                        },
                        {
                            path: "/lista-clientes",
                            icon: "mdi-account-circle",
                            text: "Clientes",
                            auth: false,
                            roles: [1],
                        },
                        {
                            path: "/lista-pedido",
                            icon: "mdi-cash",
                            text: "Pedidos",
                            auth: false,
                            roles: [1],
                        },
                        {
                            path: "/control-pedidos",
                            icon: "mdi-cash",
                            text: "Control de pedidos",
                            auth: false,
                            roles: [1],
                        },
                        {
                            path: "/generar-fabricacion",
                            icon: "mdi-factory",
                            text: "Fabricación",
                            auth: false,
                            roles: [1],
                        },
                        {
                            path: "/ver-fabricacion",
                            icon: "mdi-factory",
                            text: "Amasado",
                            auth: false,
                            roles: [1],
                        },
                        {
                            path: "/horneado",
                            icon: "mdi-toaster-oven",
                            text: "Horneado",
                            auth: false,
                            roles: [1],
                        },
                        {
                            path: "/empaquetado",
                            icon: "mdi-inbox",
                            text: "Empaquetado",
                            auth: false,
                            roles: [1],
                        },
                        {
                            path: "/guardar-constante",
                            icon: "mdi-settings",
                            text: "Configuracion",
                            auth: false,
                            roles: [1],
                        },
                        {
                            path: "/log-ingreso",
                            icon: "mdi-table",
                            text: "Log",
                            auth: false,
                            roles: [1],
                        },
                    ],
                },
            ],
            items: [],
        };
    },
    created() {
        this.rol = localStorage.getItem("role");
        console.log(this.rol);
        let items = [];
        this.items.forEach((element) => {
            let correcto = false;
            if (element.roles != null) {
                for (let i = 0; i < element.roles.length; i++) {
                    if (element.roles[i] == this.rol) {
                        items.push(element);
                        break;
                    }
                }
            } else {
                items.push(element);
            }
        });
        this.items = items;
    },
};
</script>
<style media="screen">
.v-list-item--active {
    background-color: #ffb2b2 !important;
}
</style>
