const modulo_filters = {
	strict: false,

state : {
    filtros_prueba: {
        search: null,
        opciones_familia: [],
    },
    page: 1,
    cantidad: 15,
},

getters: {
    getFiltrosPrueba(state) {
        return state.filtros_prueba;
    },
    getPage(state) {
        return state.page;
    },
    getCantidad(state) {
        return state.cantidad;
    }
},

mutations: {
    SET_FILTROS_PRUEBA(state, filtros) {
        state.filtros_prueba = filtros;
    },
    SET_PAGE(state, page) {
        state.page = page;
    },
    SET_CANTIDAD(state, cantidad) {
        state.cantidad = cantidad;
    }
},

actions: {
    updateFiltrosPrueba({ commit }, filtros) {
        console.log('filtros =>>>> ', filtros);
        commit('SET_FILTROS_PRUEBA', filtros);
    },
    updatePage({ commit }, page) {
        commit('SET_PAGE', page);
    },
    updateCantidad({ commit }, cantidad) {
        commit('SET_CANTIDAD', cantidad);
    }
}
}

export default modulo_filters;