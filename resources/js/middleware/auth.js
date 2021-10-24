import store from "../store";

export default function auth({ next, router }) {
    if (!localStorage.getItem('auth-token')) {
        store.commit('setAuth', false)
        return router.push({ name: 'login' });
    }

    return next();
}
