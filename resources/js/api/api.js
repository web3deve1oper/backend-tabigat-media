import axios from "axios";

const DEV = 'http://tabigat-media.test/';
const remoteDEV = 'https://sabadoryo.com/';
const prod = 'https://backend.tabigat.media/';

import store from '../store';
import router from '../router';

/*
 @TODO change before deploying
*/
let instance = axios.create({
    baseURL : prod
});

instance.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
instance.defaults.withCredentials = true;

instance.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    if (error.response.status === 401) {
        store.commit('triggerSnack',{color:'red', 'text': 'Ошибка авторизации'});
        localStorage.removeItem('user-token');
        store.commit('setAuth', false)
        router.push('/admin/login');
    }

    return Promise.reject(error);
})

instance.interceptors.request.use(function (config) {
    const token = localStorage.getItem('user-token');
    config.headers.Authorization = token ? `Bearer ${token}` : '';
    return config;
})

export default instance;
