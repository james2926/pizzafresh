const modulo_tipo_etiquetas = {
	strict: false,

  state:{
    tipo_etiquetas:[]
  },

	getters: {
		gettipo_etiquetas: state => state.tipo_etiquetas,
	},

	mutations: {
		get_tipo_etiquetas: (state, tipo_etiquetas) => {
			state.tipo_etiquetas = tipo_etiquetas
		},
	},

	actions: {
		getTipoEtiquetas: (context, vm) => {
      axios.get('api/get-tipos-etiqueta').then(res => {        
         context.commit('get_tipo_etiquetas', res.data)
      }, res => {

      })
		},
	}
}

export default modulo_tipo_etiquetas;
