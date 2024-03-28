import axios from 'axios';

export default function logout() {
    sessionStorage.removeItem('api_token');
    axios.post('/logout').then(() => {
        window.location.href = '/login';
    });
}
