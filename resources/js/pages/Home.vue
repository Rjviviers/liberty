<script setup lang="ts">
import { ref, onMounted } from 'vue';
import Layout from '@/layouts/DefaultLayout.vue';
import HeroSection from '@/components/sections/HeroSection.vue';
import AboutSection from '@/components/sections/AboutSection.vue';
import ServicesSection from '@/components/sections/ServicesSection.vue';
import TestimonialsSection from '@/components/sections/TestimonialsSection.vue';
import FeaturesSection from '@/components/sections/FeaturesSection.vue';
import ContactSection from '@/components/sections/ContactSection.vue';
import BookingModal from '@/components/BookingModal.vue';

interface Testimonial {
  id: number;
  name: string;
  detail: string;
  text: string;
}

defineProps<{
  testimonials: Testimonial[];
}>();

const bookingModalOpen = ref(false);

const openBookingModal = () => {
  bookingModalOpen.value = true;
};

const closeBookingModal = () => {
  bookingModalOpen.value = false;
};

// Theme settings
const themeSelectorOpen = ref(false);
const currentPalette = ref(localStorage.getItem('palette') || 'classic');

const toggleThemeSelector = () => {
  themeSelectorOpen.value = !themeSelectorOpen.value;
};

const themeOptions = [
  { id: 'classic', name: 'Classic Blue & Orange' },
  { id: 'ocean', name: 'Ocean Blues' },
  { id: 'forest', name: 'Forest Green' },
  { id: 'midnight', name: 'Midnight Purple' },
  { id: 'gothic', name: 'Gothic Pink' },
  { id: 'earthdark', name: 'Dark Earth' }
];

const changeThemePalette = (paletteId: string) => {
  document.body.classList.remove(
    'theme-classic', 
    'theme-ocean',
    'theme-forest',
    'theme-midnight',
    'theme-gothic',
    'theme-earthdark'
  );
  
  if (paletteId !== 'floral') {
    document.body.classList.add(`theme-${paletteId}`);
  }
  
  currentPalette.value = paletteId;
  localStorage.setItem('palette', paletteId);
};

// Scroll to top
const showScrollTop = ref(false);

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
};

const handleScroll = () => {
  if (window.pageYOffset > 300) {
    showScrollTop.value = true;
  } else {
    showScrollTop.value = false;
  }
  
  // Add scrolled class to header
  const header = document.querySelector('header');
  if (header) {
    if (window.pageYOffset > 50) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  }
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
  
  // Apply stored theme
  if (currentPalette.value) {
    changeThemePalette(currentPalette.value);
  }
});
</script>

<template>
  <Layout>
    <!-- Theme selector button and panel -->
    <div class="theme-selector-toggle" @click="toggleThemeSelector">
      <i class="fas fa-palette"></i>
    </div>
    
    <div class="theme-selector-panel" :class="{'active': themeSelectorOpen}">
      <h3>Choose Theme</h3>
      <div class="theme-options">
        <div v-for="theme in themeOptions" :key="theme.id"
             :class="['theme-option', `theme-${theme.id}`, {'active': currentPalette === theme.id}]"
             @click="changeThemePalette(theme.id)">
          {{ theme.name }}
          <div class="color-preview">
            <div class="color-dot primary"></div>
            <div class="color-dot secondary"></div>
            <div class="color-dot bg"></div>
            <div class="color-dot light"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Scroll to top button -->
    <div class="scroll-top" :class="{'visible': showScrollTop}" @click="scrollToTop">
      <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Main sections -->
    <HeroSection @open-booking="openBookingModal" />
    <AboutSection />
    <ServicesSection />
    <TestimonialsSection :testimonials="testimonials" />
    <FeaturesSection />
    <ContactSection @open-booking="openBookingModal" />

    <!-- Booking Modal -->
    <BookingModal 
      :is-open="bookingModalOpen" 
      @close="closeBookingModal" 
    />
  </Layout>
</template> 