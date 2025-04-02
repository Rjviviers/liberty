<script setup lang="ts">
import Layout from '@/layouts/DefaultLayout.vue';
import BookingModal from '@/components/BookingModal.vue';
import { ref } from 'vue';

const bookingModalOpen = ref(false);

const openBookingModal = () => {
  bookingModalOpen.value = true;
};

const closeBookingModal = () => {
  bookingModalOpen.value = false;
};

const services = [
  {
    id: 1,
    title: 'Primary Care',
    description: 'Comprehensive healthcare services for patients of all ages, focusing on prevention, diagnosis, and treatment of common illnesses.',
    icon: 'fa-user-md'
  },
  {
    id: 2,
    title: 'Specialized Treatments',
    description: 'Advanced treatment options for complex conditions, utilizing the latest medical technologies and evidence-based approaches.',
    icon: 'fa-stethoscope'
  },
  {
    id: 3,
    title: 'Wellness Programs',
    description: 'Personalized wellness plans that promote healthy lifestyles, disease prevention, and overall wellbeing.',
    icon: 'fa-heartbeat'
  },
  {
    id: 4,
    title: 'Diagnostic Services',
    description: 'Comprehensive diagnostic testing to identify and assess medical conditions with accuracy and efficiency.',
    icon: 'fa-microscope'
  },
  {
    id: 5,
    title: 'Rehabilitation',
    description: 'Therapeutic services designed to help patients recover from injuries, surgeries, or illnesses and regain optimal function.',
    icon: 'fa-walking'
  },
  {
    id: 6,
    title: 'Chronic Care Management',
    description: 'Ongoing support and management strategies for patients living with chronic health conditions.',
    icon: 'fa-chart-line'
  }
];
</script>

<template>
  <Layout>
    <div class="container mx-auto py-12 px-4">
      <h1 class="text-4xl font-bold text-center mb-8">Our Services</h1>
      
      <p class="text-center max-w-3xl mx-auto mb-12">We offer a comprehensive range of healthcare services designed to meet your unique needs. Our team of experienced professionals is dedicated to providing personalized care with compassion and expertise.</p>
      
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        <div v-for="service in services" :key="service.id" class="bg-white p-6 rounded-lg shadow-md transition-transform hover:transform hover:-translate-y-2">
          <div class="text-primary-color text-4xl mb-4">
            <i :class="['fas', service.icon]"></i>
          </div>
          <h3 class="text-xl font-semibold mb-3">{{ service.title }}</h3>
          <p class="text-gray-600">{{ service.description }}</p>
        </div>
      </div>
      
      <div class="bg-bg-light p-8 rounded-lg mb-12">
        <h2 class="text-2xl font-semibold mb-4 text-center">Our Approach</h2>
        <div class="grid md:grid-cols-3 gap-6">
          <div class="text-center p-4">
            <div class="rounded-full bg-primary-light p-4 w-16 h-16 flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-user-check text-primary-color text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold">Patient-Centered</h3>
            <p class="text-gray-600">Your needs and preferences guide all aspects of your care.</p>
          </div>
          <div class="text-center p-4">
            <div class="rounded-full bg-primary-light p-4 w-16 h-16 flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-clipboard-check text-primary-color text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold">Evidence-Based</h3>
            <p class="text-gray-600">We incorporate the latest research and clinical guidelines into our practice.</p>
          </div>
          <div class="text-center p-4">
            <div class="rounded-full bg-primary-light p-4 w-16 h-16 flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-hands-helping text-primary-color text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold">Collaborative</h3>
            <p class="text-gray-600">We work as a team with you and other healthcare providers for optimal outcomes.</p>
          </div>
        </div>
      </div>
      
      <div class="text-center">
        <button 
          @click="openBookingModal"
          class="bg-primary-color hover:bg-primary-dark text-white px-6 py-3 rounded-md transition duration-300"
        >
          Schedule a Service
        </button>
      </div>
    </div>
    
    <!-- Booking Modal -->
    <BookingModal 
      :is-open="bookingModalOpen" 
      @close="closeBookingModal" 
    />
  </Layout>
</template> 