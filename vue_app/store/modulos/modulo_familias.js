const modulo_familias = {
	strict: false,

  state:{
    familias:[],
  },

	getters: {
		getfamilias: state => state.familias,
	},

	mutations: {
		get_familias: (state, familias) => {
			state.familias = familias
		},
	},

	actions: {
		getFamilias: (context, vm) => {
			axios.get('api/get-articulo-familias').then(res => {        
				context.commit('get_familias', res.data)
			}, res => {

			})
		},
	
		deleteFamilia:({ commit, state },vm) =>{
	
			axios
                .get(`api/delete-articulo-familia/${ vm.id}`)
                .then((res) => {
					commit('get_familias', res.data)

                })
                .catch((error) => {
                });
		},
		saveFamilia:({ commit, state },vm) =>{
			console.log(state);
			axios
                .post(`api/save-articulo-familia`,vm)
                .then((res) => {
					commit('get_familias', res.data)

                })
                .catch((error) => {
					console.log(error);
                });
		}
	}
}

export default modulo_familias;
