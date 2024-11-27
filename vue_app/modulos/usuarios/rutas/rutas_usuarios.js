import FormUsuarios from '../componentes/FormUsuarios.vue'
import ListaUsuarios from '../componentes/ListaUsuarios.vue'


const routes = [
    ...route('/guardar-usuario', FormUsuarios, {
        Auth: true,
        req_admin: true
     }),
     ...route('/lista-usuario', ListaUsuarios, {
       Auth: true,
       //req_admin: true
    }),
]

function route(path, component = Default, meta = {}) {
	return [{
		path,
		component,
		meta
	}]
}

export default routes