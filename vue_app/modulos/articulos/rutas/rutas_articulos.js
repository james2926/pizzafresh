import FormArticulos from "../componentes/FormArticulos.vue";
import ListaArticulos from "../componentes/ListaArticulos.vue";

const routes = [
    ...route("/guardar-articulo", FormArticulos, {
        Auth: true,
        // req_admin: true
    }),
    ...route("/lista-articulo", ListaArticulos, {
        Auth: true,
        //req_admin: true
    }),
];

function route(path, component = Default, meta = {}) {
    return [
        {
            path,
            component,
            meta,
        },
    ];
}

export default routes;
