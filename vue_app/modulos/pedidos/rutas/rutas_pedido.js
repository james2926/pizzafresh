import FormPedidos from '../componentes/FormPedidos.vue'
import ListaPedidos from '../componentes/ListaPedidos.vue'


const routes = [
    ...route('/guardar-pedido', FormPedidos, {
        Auth: true,
        req_admin: true
     }),
     ...route('/lista-pedido', ListaPedidos, {
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