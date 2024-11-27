const modulo_aux = {
	strict: false,

  state:{
    pais:[]
  },

	getters: {
		getpais: state => state.pais,
	},

	mutations: {
		get_pais: (state, pais) => {
			state.pais = pais
		},
	},

	actions: {
		getPais: (context, vm) => {
      axios.get('api/get-paises').then(res => {        
         context.commit('get_pais', res.data)
      }, res => {

      })
		},
	}
}

export default modulo_aux;
