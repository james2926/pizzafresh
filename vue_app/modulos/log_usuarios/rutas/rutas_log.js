import ListaLog from "../componentes/ListaLog.vue";

const routes = [
    ...route("/log-ingreso", ListaLog, {
        Auth: true,
        req_admin: true,
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
