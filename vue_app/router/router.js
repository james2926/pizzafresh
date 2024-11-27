import Vue from "vue";
import VueRouter from "vue-router";
import auth from "../auth/auth.js";

import Inicio from "../components/inicio/Inicio.vue";
import Login from "../components/login/Login.vue";
import ForgotPassword from "../components/login/ForgotPassword.vue";
import ResetPassword from "../components/login/ResetPassword.vue";

import rutas_usuarios from "../modulos/usuarios/rutas/rutas_usuarios";
import rutas_articulos from "../modulos/articulos/rutas/rutas_articulos";
import rutas_clientes from "../modulos/clientes/rutas/rutas_clientes";
import rutas_pedido from "../modulos/pedidos/rutas/rutas_pedido";
import rutas_control_pedido from "../modulos/control_pedidos/rutas/rutas_control_pedido";
import rutas_constantes from "../modulos/constantes/rutas/rutas_constantes";
import rutas_fabricacion from "../modulos/fabricacion/rutas/rutas_fabricacion";
import rutas_produccion from "../modulos/produccion/rutas/rutas_produccion";
import rutas_log from "../modulos/log_usuarios/rutas/rutas_log";

import ListaUsuarios from "../modulos/usuarios/componentes/ListaUsuarios.vue";

Vue.use(VueRouter);

/* importar rutas */

const base_routes = [
    ...route("/login", Login),
    ...route("/forgot", ForgotPassword),
    ...route("/reset-password", ResetPassword),

    ...route("/", Inicio, {
        Auth: true,
    }),
    ...route("/lista-usuario", ListaUsuarios, {
        Auth: true,
        req_admin: true,
    }),
];

const routes = [
    ...base_routes,
    ...rutas_usuarios,
    ...rutas_articulos,
    ...rutas_clientes,
    ...rutas_pedido,
    ...rutas_control_pedido,
    ...rutas_constantes,
    ...rutas_fabricacion,
    ...rutas_produccion,
    ...rutas_log,
];

const router = new VueRouter({
    routes,
});

function route(path, component = Default, meta = {}) {
    return [
        {
            path,
            component,
            meta,
        },
    ];
}

router.beforeEach((to, from, next) => {
    if ((to.path == "/login") & auth.authenticated()) {
        next({
            path: "/",
            query: {
                redirect: to.fullPath,
            },
        });
    }

    if (to.meta.Auth) {
        const authUser = localStorage.getItem("role");
        if (!auth.authenticated()) {
            next({
                path: "/login",
                query: {
                    redirect: to.fullPath,
                },
            });
        } else if (to.meta.req_admin) {
            authUser == 1 ? next() : next("/");
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
