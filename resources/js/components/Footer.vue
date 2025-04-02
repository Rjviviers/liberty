<script setup lang="ts">
import { ref } from 'vue';

// Define the content prop interface
interface FooterContent {
  about?: string;
  links?: Array<{text: string, url: string}>;
  contact?: string;
}

// Define the prop with default values
const props = defineProps<{
  content?: FooterContent;
}>();

// Default content in case the prop is not provided
const defaultContent = {
  about: 'Danie de Villiers offers personalized biokinetic treatments to improve your movement, fitness, and quality of life. Experience the difference with evidence-based rehabilitation.',
  links: [
    { text: 'Home', url: '/' },
    { text: 'About', url: '/about' },
    { text: 'Services', url: '/services' },
    { text: 'Contact', url: '/contact' }
  ],
  contact: 'Get in touch with us for appointments, inquiries, or any questions you might have about our biokinetic services.'
};

// Merge provided content with defaults
const mergedContent = ref({
  ...defaultContent,
  ...props.content
});

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
  <footer class="footer-section relative overflow-hidden py-16 md:py-24 lg:py-32 bg-bg-dark text-white">
    <!-- Background Effects -->
    <div class="absolute inset-0 grid-pattern opacity-10 dark:opacity-5"></div>
    
    <div class="container mx-auto px-4 relative z-10">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="fade-in">
          <h3 class="text-2xl font-bold text-white mb-4">About Us</h3>
          <p class="text-gray-300 dark:text-gray-200 mt-4 leading-relaxed">{{ mergedContent.about }}</p>
        </div>
        <div class="fade-in">
          <h3 class="text-2xl font-bold text-white mb-4">Quick Links</h3>
          <ul class="mt-4 space-y-2">
            <li v-for="(link, index) in mergedContent.links" :key="index">
              <a :href="link.url" class="text-gray-300 dark:text-gray-200 hover:text-primary-color transition duration-300 flex items-center">
                <i class="fas fa-chevron-right text-xs mr-2 text-primary-color"></i>
                <span>{{ link.text }}</span>
              </a>
            </li>
          </ul>
        </div>
        <div class="fade-in">
          <h3 class="text-2xl font-bold text-white mb-4">Contact Us</h3>
          <p class="text-gray-300 dark:text-gray-200 mt-4 leading-relaxed mb-4">{{ mergedContent.contact }}</p>
          
          <div class="space-y-3">
            <div class="flex items-start">
              <div class="text-primary-color mr-3 mt-1">
                <i class="fas fa-map-marker-alt"></i>
              </div>
              <span class="text-gray-300 dark:text-gray-200">{{ bioInfo.location }}</span>
            </div>
            
            <div class="flex items-start">
              <div class="text-primary-color mr-3 mt-1">
                <i class="fas fa-phone"></i>
              </div>
              <a href="tel:0783932622" class="text-gray-300 dark:text-gray-200 hover:text-primary-color transition">
                {{ bioInfo.phone }}
              </a>
            </div>
            
            <div class="flex items-start">
              <div class="text-primary-color mr-3 mt-1">
                <i class="fas fa-envelope"></i>
              </div>
              <a href="mailto:daniedevilliersbio@gmail.com" class="text-gray-300 dark:text-gray-200 hover:text-primary-color transition">
                {{ bioInfo.email }}
              </a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="mt-12 pt-8 border-t border-gray-700">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="text-gray-400 mb-4 md:mb-0">
            &copy; {{ currentYear }} {{ bioInfo.name }}. All rights reserved.
          </div>
          
          <div class="flex space-x-4">
            <a href="#" class="social-link" aria-label="Facebook">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-link" aria-label="Instagram">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="social-link" aria-label="LinkedIn">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<style scoped>
.footer-section {
  background-color: var(--bg-dark, #1a1a1a);
  color: white;
}

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
  color: var(--text-color-light, #f1f1f1);
  opacity: 0.9;
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
  color: var(--primary-color);
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
  background-color: rgba(255, 255, 255, 0.1);
  color: white;
  transition: all 0.3s ease;
}

.social-link:hover {
  background-color: var(--primary-color);
  transform: translateY(-3px);
  color: white;
}

.footer-button {
  background-color: var(--primary-color);
  color: white;
  font-weight: 600;
  border: none;
  transition: all 0.3s ease;
}

.footer-button:hover {
  background-color: var(--primary-dark);
  transform: translateY(-2px);
}

@media (prefers-color-scheme: dark) {
  .footer-section {
    background-color: var(--bg-darker, #121212);
  }
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