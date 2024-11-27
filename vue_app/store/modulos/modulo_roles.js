const modulo_roles = {
	strict: false,

  state:{
    roles:[]
  },

	getters: {
		getroles: state => state.roles,
	},

	mutations: {
		get_roles: (state, roles) => {
			state.roles = roles
		},
	},

	actions: {
		getRoles: (context, vm) => {
      axios.get('api/getroles').then(res => {        
         context.commit('get_roles', res.data)
      }, res => {

      })
		},
	}
}

export default modulo_roles;
