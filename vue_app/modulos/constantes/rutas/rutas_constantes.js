import FormConstantes from '../componentes/FormConstantes.vue'


const routes = [
    ...route('/guardar-constante', FormConstantes, {
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