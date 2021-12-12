import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        login: false,
        nome: "",
        usuario: {
            usu_array: [],
            id: "",
        }
    },
    mutations: {
        UPDATE_LISTA(state, payload){
            // console.log(JSON.stringify(state));
            // console.log(JSON.stringify(payload));
            state.nome = payload;
        }
    },
    actions: {}
});