const modulo_fabricantes = {
	strict: false,

  state:{
    fabricantes:[],
  },

	getters: {
		getfabricantes: state => state.fabricantes,
	},

	mutations: {
		get_fabricantes: (state, fabricantes) => {
			state.fabricantes = fabricantes
		},
	},

	actions: {
		getFabricantes: (context, vm) => {
			axios.get('api/get-articulo-fabricantes').then(res => {        
				context.commit('get_fabricantes', res.data)
			}, res => {

			})
		},
	
		deleteFabricante:({ commit, state },vm) =>{
	
			axios
                .get(`api/delete-articulo-fabricante/${ vm.id}`)
                .then((res) => {
					commit('get_fabricantes', res.data)

                })
                .catch((error) => {
                });
		},
		saveFabricante:({ commit, state },vm) =>{
			console.log(state);
			axios
                .post(`api/save-articulo-fabricante`,vm)
                .then((res) => {
					commit('get_fabricantes', res.data)

                })
                .catch((error) => {
					console.log(error);
                });
		}
	}
}

export default modulo_fabricantes;
