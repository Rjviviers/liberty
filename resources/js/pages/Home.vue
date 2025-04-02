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

interface HeroContent {
  heading: string;
  subheading: string;
  description: string;
  image: string;
  button_text: string;
  admin_button_text: string;
}

defineProps<{
  testimonials: Testimonial[];
  heroContent: HeroContent;
  aboutContent: any; // Add about content
  featuresContent: any; // Add proper interface if needed
  servicesContent: any; // Add proper interface if needed
  testimonialsContent: any; // Add proper interface if needed
  contactContent: any; // Add proper interface if needed
}>();

const bookingModalOpen = ref(false);

const openBookingModal = () => {
  bookingModalOpen.value = true;
};

const closeBookingModal = () => {
  bookingModalOpen.value = false;
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
});
</script>

<template>
  <Layout>
    <!-- Scroll to top button -->
    <div class="scroll-top" :class="{'visible': showScrollTop}" @click="scrollToTop">
      <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Main sections -->
    <HeroSection 
      :content="heroContent"
      @open-booking="openBookingModal" 
    />
    <AboutSection :content="aboutContent" />
    <ServicesSection :content="servicesContent" />
    <TestimonialsSection :testimonials="testimonials" :content="testimonialsContent" />
    <FeaturesSection :content="featuresContent" />
    <ContactSection :content="contactContent" @open-booking="openBookingModal" />

    <!-- Booking Modal -->
    <BookingModal 
      :is-open="bookingModalOpen" 
      @close="closeBookingModal" 
    />
  </Layout>
</template> 