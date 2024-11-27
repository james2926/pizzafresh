import Index from '../componentes/Index.vue'


const routes = [
     ...route('/control-pedidos', Index, {
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