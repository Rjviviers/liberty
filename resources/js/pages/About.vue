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
</script>

<template>
  <Layout>
    <div class="container mx-auto py-12 px-4">
      <h1 class="text-4xl font-bold text-center mb-8">About Us</h1>
      
      <div class="grid md:grid-cols-2 gap-8 mb-12">
        <div>
          <h2 class="text-2xl font-semibold mb-4">My Story</h2>
          <p class="mb-4">Danie de Villiers began his career with a simple but powerful vision: to provide compassionate, personalized biokinetic care that empowers patients to live their best lives through movement therapy.</p>
          <p class="mb-4">For over 15 years, he has been serving the community with dedication and expertise, building relationships based on trust and respect.</p>
          <p>With extensive training and continuous professional development, Danie brings years of practical experience in biokinetics, with specializations in rehabilitation, chronic disease management, and sports performance enhancement.</p>
        </div>
        <div class="bg-gray-100 p-6 rounded-lg">
          <h2 class="text-2xl font-semibold mb-4">My Mission</h2>
          <p class="mb-4">To deliver exceptional biokinetic services that prioritize patient dignity, comfort, and wellbeing through evidence-based exercise therapy.</p>
          <h2 class="text-2xl font-semibold mb-4 mt-6">My Values</h2>
          <ul class="list-disc pl-5">
            <li class="mb-2">Compassion in every interaction</li>
            <li class="mb-2">Excellence in biokinetic practice</li>
            <li class="mb-2">Integrity in all professional relationships</li>
            <li class="mb-2">Respect for each individual's recovery journey</li>
            <li>Innovation in exercise therapy solutions</li>
          </ul>
        </div>
      </div>
      
      <div class="text-center">
        <button 
          @click="openBookingModal"
          class="bg-primary-color hover:bg-primary-dark text-white px-6 py-3 rounded-md transition duration-300"
        >
          Schedule a Consultation
        </button>
      </div>
    </div>
    
    <!-- Booking Modal -->
    <BookingModal 
      v-if="bookingModalOpen" 
      @close="closeBookingModal" 
    />
  </Layout>
</template> 