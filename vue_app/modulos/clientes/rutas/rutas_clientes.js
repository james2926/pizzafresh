import FormClientes from '../componentes/FormClientes.vue'
import ListaClientes from '../componentes/ListaClientes.vue'



const routes = [
    ...route('/guardar-cliente', FormClientes, {
        Auth: true,
        ///req_admin: true
     }),
     ...route('/lista-clientes', ListaClientes, {
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