// Bootstrap
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';



import axios from 'axios';
window.axios = axios;

import Swal from 'sweetalert2'
window.Swal = Swal;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
