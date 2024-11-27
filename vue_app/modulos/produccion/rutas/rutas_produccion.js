import FormProduccion from '../componentes/FormProduccion.vue'
import Empaquetado from '../componentes/Empaquetado.vue'
import Horneado from '../componentes/Horneado.vue'


const routes = [
    ...route('/generar-produccion', FormProduccion, {
        Auth: true,
        req_admin: true
     }),
	 ...route('/empaquetado', Empaquetado, {
        Auth: true,
        req_admin: true
     }),
	 ...route('/horneado', Horneado, {
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