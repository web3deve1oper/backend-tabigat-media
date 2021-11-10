import axios from "axios";

const DEV = 'http://tabigat-media.test/';
// const remoteDEV = 'http://sleepy-lowlands-53073.herokuapp.com/';

import store from '../store';
import router from '../router';

/*
 @TODO change before deploying
*/
let instance = axios.create({
    baseURL : DEV
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
