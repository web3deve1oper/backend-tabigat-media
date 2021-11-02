import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        count: 1,
        isAuth: true,
        headerText: '',
        snack: null,
        snackColor: 'green',
        snackText: ''
    },
    mutations: {
        increment(state, payload) {

        },
        setAuth(state, bool) {
            state.isAuth = bool;
        },
        changeHeaderText(state, text) {
            state.headerText = text;
        },
        triggerSnack(state,attrs) {
            state.snack = true;
            state.snackColor = attrs.color;
            state.snackText = attrs.text;
        },
        closeSnack(state, attrs) {
            state.snack = null;
        },
        refreshCsrf(state, attrs) {
            state.csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    },
    actions: {
        increment(context, payload) {
            context.commit('increment', payload)
        }
    },
    getters: {}
})
