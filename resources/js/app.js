
import './bootstrap';
import 'bootstrap';
//import * as bootstrap from 'bootstrap'; // Import complet de Bootstrap
//window.bootstrap = bootstrap; // Rend Bootstrap accessible partout !

import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

flatpickr("input[type='date']", {});

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
