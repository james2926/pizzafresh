<template>
    <v-app style="background-color: #eeeeee">
        <top
            v-if="
                $route.path !== '/login' &&
                $route.path !== '/pedir-cita' &&
                $route.path !== '/forgot' &&
                $route.path !== '/reset-password'
            "
            v-on:toggleDrawer="toggleDrawer"
        ></top>
        <lateral
            v-if="
                $route.path !== '/login' &&
                $route.path !== '/pedir-cita' &&
                $route.path !== '/forgot' &&
                $route.path !== '/reset-password'
            "
            :drawer="drawer"
            v-on:emitInnputDrawer="getInnputDrawer"
        ></lateral>

        <v-main color="purple darken-3">
            <v-container
                fluid
                grid-list-xs
                :class="
                    $route.path == '/login' ||
                    $route.path == '/pedir-cita' ||
                    $route.path == '/reset-password' ||
                    $route.path == '/forgot'
                        ? 'pa-0'
                        : ''
                "
            >
                <router-view></router-view>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import Top from "../navs/Top.vue";
import Lateral from "../navs/Lateral.vue";
export default {
    components: {
        Top,
        Lateral,
    },
    watch: {
        drawer: {
            immediate: true,
            handler: function (n) {},
        },
    },
    data() {
        return {
            drawer: true,
        };
    },
    methods: {
        isActive() {
            return false; //this.$route.path != '/login'
        },
        toggleDrawer() {
            this.drawer = !this.drawer;
        },
        getInnputDrawer(e) {
            this.drawer = e;
        },
    },
};
</script>

<style media="screen">
.v-list-group__header__prepend-icon {
    color: black !important;
}
.v-application {
    font-family: "Roboto", sans-serif !important;
}
.title {
    font-family: "Roboto", sans-serif !important;
}

.my-container {
    padding: 1rem;
}

.v-content__wrap {
    background-color: #efeeee;
}

a {
    text-decoration: none;
}
.pointer {
    cursor: pointer;
}
/*.v-toolbar__title {
        font-weight: 300;
        color: #555;
        font-size: 18px;
        margin-bottom: 6px;
    }*/
</style>
