
import modulo_roles from './modulos/modulo_roles'
import modulo_familias from './modulos/modulo_familias'
import modulo_fabricantes from './modulos/modulo_fabricante'
import modulo_filters from './modulos/filters'

import Vue from "vue"
import Vuex from "vuex"
import modulo_tipo_etiquetas from './modulos/modulo_etiqueta'
import modulo_clientes from './modulos/modulo_clientes'
import modulo_aux from './modulos/modulo_aux'
Vue.use(Vuex)

const store = new Vuex.Store({
	strict: false,
	modules: {
		
		roles: modulo_roles,
		familias:modulo_familias,
		filters: modulo_filters,
		fabricantes:modulo_fabricantes,
		etiquetas:modulo_tipo_etiquetas,
		clientes:modulo_clientes,
		aux:modulo_aux,
	},
})

export default store;
