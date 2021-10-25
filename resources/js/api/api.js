import axios from "axios";

const DEV = 'http://tabigat-media.test/';
const remoteDEV = 'http://sleepy-lowlands-53073.herokuapp.com/';

let instance = axios.create({
    baseURL : remoteDEV
});

instance.interceptors.request.use(function (config) {
    const token = localStorage.getItem('user-token');
    config.headers.Authorization = token ? `Bearer ${token}` : '';
    return config;
})

export default instance;
