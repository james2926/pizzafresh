import router from '../router/router.js'
import Vue from 'vue'
import store from '../store/store.js'
export default {
	user: {
		authenticated: false,
	},

	signin: function (user) {
		axios.post('api/login', user).then(response => {
			this.setLocalStorage(response.data)
			this.user.authenticated = true
			axios.defaults.headers.common['Authorization'] = ' Bearer ' + response.data.token
			store.dispatch('getRoles', this);
			store.dispatch('getPais', this);

			router.push('/')
		}).catch(error => {
			console.log(error.response.status);
			if(error.response.status == 401){
				alert(error.response.data.message);
			}
			//this.$custom_error('Acceso denegado')
		})
	},



	dispatchUser: function (data) {
		store.dispatch('setAuth', true)
		store.dispatch('setUser', data)
	},

	setLocalStorage: function (data) {
		localStorage.setItem('id_token', data.token)
		localStorage.setItem('role', data.user.id_role)

	},

	logout: function () {
		localStorage.removeItem('id_token')
		//store.dispatch('setAuth', false)
		//store.dispatch('setUser', this.setDefault())
		router.push('/login')
	},

	setDefault: function () {
		return {
			name: '...',
		}
	},

	authenticated: function () {
		return this.check()
	},

	check: function () {
		return (localStorage.getItem('id_token') !== null) ? true : false
	}
}
