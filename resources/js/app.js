import './bootstrap';
import 'bootstrap';       // adds Bootstrap JS components

import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';

flatpickr("input[type='date']", {});

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
