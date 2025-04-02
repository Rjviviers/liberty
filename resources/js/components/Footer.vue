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
  <footer class="footer-section relative overflow-hidden py-16 md:py-24 lg:py-32">
    <!-- Background Effects -->
    <div class="absolute inset-0 grid-pattern opacity-10 dark:opacity-5"></div>
    
    <div class="container mx-auto px-4 relative z-10">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="fade-in">
          <h3 class="gradient-text text-2xl font-bold">About Us</h3>
          <p class="text-gray-600 dark:text-gray-400 mt-4">{{ content.about }}</p>
        </div>
        <div class="fade-in">
          <h3 class="gradient-text text-2xl font-bold">Quick Links</h3>
          <ul class="mt-4">
            <li v-for="(link, index) in content.links" :key="index">
              <a :href="link.url" class="text-gray-600 dark:text-gray-400 hover:text-primary-color">{{ link.text }}</a>
            </li>
          </ul>
        </div>
        <div class="fade-in">
          <h3 class="gradient-text text-2xl font-bold">Contact Us</h3>
          <p class="text-gray-600 dark:text-gray-400 mt-4">{{ content.contact }}</p>
        </div>
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

.footer-button {
  background-color: var(--secondary-color);
  color: white;
  font-weight: 600;
  border: 2px solid white;
  transition: var(--transition-normal);
}

.footer-button:hover {
  background-color: var(--secondary-dark);
  transform: translateY(-2px);
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

/* Global Gradient Text */
.gradient-text {
  background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
}

/* Floating Elements */
@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-20px); }
}

/* Noise Background */
.noise-bg {
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
  opacity: 0.08;
  mix-blend-mode: overlay;
}
</style> 