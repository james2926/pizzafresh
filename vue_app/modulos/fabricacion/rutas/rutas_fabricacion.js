import FormFabricacion from '../componentes/FormFabricacion.vue'
import FabricacionEmpleados from '../componentes/FabricacionEmpleados.vue'


const routes = [
    ...route('/generar-fabricacion', FormFabricacion, {
        Auth: true,
        req_admin: true
     }),
	 ...route('/ver-fabricacion', FabricacionEmpleados, {
        Auth: true,
        req_admin: true
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