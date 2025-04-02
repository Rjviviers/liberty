import './bootstrap';
import '../css/app.css';

import { createApp } from 'vue/dist/vue.esm-bundler.js';

// Import components
import HomeComponent from './pages/Home.vue';
import AboutComponent from './pages/About.vue';
import ServicesComponent from './pages/Services.vue';
import ContactComponent from './pages/Contact.vue';
import NavBar from './components/NavBar.vue';
import Footer from './components/Footer.vue';
import BookingModal from './components/BookingModal.vue';
import ThemeSelector from './components/ThemeSelector.vue';

// Import Font Awesome
import '@fortawesome/fontawesome-free/css/all.css';

// Create Vue app with empty options object
const app = createApp({});

// Register components globally
app.component('home-component', HomeComponent);
app.component('about-component', AboutComponent);
app.component('services-component', ServicesComponent);
app.component('contact-component', ContactComponent);
app.component('nav-bar', NavBar);
app.component('footer-component', Footer);
app.component('booking-modal', BookingModal);
app.component('theme-selector', ThemeSelector);

// Mount the app when document is ready
document.addEventListener('DOMContentLoaded', () => {
  const appElement = document.getElementById('app');
  if (appElement) {
    app.mount('#app');
    console.log('Vue app mounted successfully');
  } else {
    console.error('Could not find #app element to mount Vue app');
  }
}); 