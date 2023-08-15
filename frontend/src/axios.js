import axios from 'axios';

const token = window.localStorage.getItem('token')
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

axios.defaults.baseURL = 'http://127.0.0.1:8000/api/';