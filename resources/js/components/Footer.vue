<script setup lang="ts">
import { ref } from 'vue';

const bioInfo = ref({
  name: 'Danie de Villiers',
  phone: '078 393 2622',
  email: 'daniedevilliersbio@gmail.com',
  location: '4 Jonie street, Annlin, Pretoria'
});

const currentYear = new Date().getFullYear();
const emit = defineEmits<{
  (e: 'open-booking'): void;
}>();
</script>

<template>
  <footer class="bg-primary-color text-white py-16">
    <div class="container mx-auto px-4">
      <div class="footer-content">
        <div class="footer-column">
          <h3 class="text-xl font-semibold mb-4">{{ bioInfo.name }}</h3>
          <p class="mb-3">Professional Biokineticist</p>
          <p class="opacity-80 mb-4">Helping patients recover and achieve optimal physical performance.</p>
          <div class="flex space-x-4 mt-4">
            <a href="#" class="social-link">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-link">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-link">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="social-link">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </div>
        
        <div class="footer-column">
          <h3 class="text-xl font-semibold mb-4">Quick Links</h3>
          <ul class="footer-links space-y-2">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#testimonials">Testimonials</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div>
        
        <div class="footer-column">
          <h3 class="text-xl font-semibold mb-4">Contact</h3>
          <div class="contact-info space-y-3">
            <div class="contact-item">
              <i class="fas fa-phone"></i>
              <span>{{ bioInfo.phone }}</span>
            </div>
            <div class="contact-item">
              <i class="fas fa-envelope"></i>
              <span>{{ bioInfo.email }}</span>
            </div>
            <div class="contact-item">
              <i class="fas fa-map-marker-alt"></i>
              <span>{{ bioInfo.location }}</span>
            </div>
          </div>
        </div>
        
        <div class="footer-column">
          <h3 class="text-xl font-semibold mb-4">Hours</h3>
          <div class="hours-info space-y-3">
            <div class="hours-item">
              <span class="day">Monday - Friday:</span>
              <span class="time">8:00 AM - 5:00 PM</span>
            </div>
            <div class="hours-item">
              <span class="day">Saturday:</span>
              <span class="time">9:00 AM - 1:00 PM</span>
            </div>
            <div class="hours-item">
              <span class="day">Sunday:</span>
              <span class="time">Closed</span>
            </div>
          </div>
          
          <button @click="emit('open-booking')" class="btn mt-6 bg-white text-primary-color hover:bg-opacity-90 w-full">
            Book Appointment
          </button>
        </div>
      </div>
      
      <div class="footer-copyright border-t border-white border-opacity-20 mt-12 pt-8 text-center">
        <p>&copy; {{ currentYear }} {{ bioInfo.name }} | Biokinetics. All rights reserved.</p>
      </div>
    </div>
  </footer>
</template>

<style scoped>
.footer-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
}

.footer-links {
  list-style: none;
  padding: 0;
}

.footer-links a {
  color: white;
  opacity: 0.8;
  transition: var(--transition-normal);
  display: inline-block;
  padding: 0.25rem 0;
}

.footer-links a:hover {
  opacity: 1;
  transform: translateX(5px);
}

.contact-item, .hours-item {
  display: flex;
  gap: 1rem;
  align-items: flex-start;
}

.contact-item i {
  color: var(--secondary-color);
  width: 20px;
  margin-top: 5px;
}

.hours-item .day {
  font-weight: 500;
  min-width: 120px;
}

.social-link {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background-color: rgba(255, 255, 255, 0.2);
  color: white;
  transition: var(--transition-normal);
}

.social-link:hover {
  background-color: var(--secondary-color);
  transform: translateY(-3px);
}

@media (max-width: 768px) {
  .footer-content {
    gap: 2.5rem;
  }
  
  .footer-column:not(:last-child) {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding-bottom: 2rem;
  }
}
</style> 