import axios from "axios";

const DEV = 'http://tabigat-media.test/';

let instance = axios.create({
    baseURL : DEV
});

instance.interceptors.request.use(function (config) {
    const token = localStorage.getItem('user-token');
    config.headers.Authorization = token ? `Bearer ${token}` : '';
    return config;
})

export default instance;
