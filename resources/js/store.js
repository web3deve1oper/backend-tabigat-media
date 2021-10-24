import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        count: 1,
        isAuth: true,
        headerText: ''
    },
    mutations: {
        increment(state, payload) {

        },
        setAuth(state, bool) {
            state.isAuth = bool;
        },
        changeHeaderText(state, text) {
            state.headerText = text;
        }
    },
    actions: {
        increment(context, payload) {
            context.commit('increment', payload)
        }
    },
    getters: {}
})
