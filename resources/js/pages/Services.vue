<script setup lang="ts">
import Layout from '@/layouts/DefaultLayout.vue';
import BookingModal from '@/components/BookingModal.vue';
import { ref, computed } from 'vue';

// Define the props interface
interface ServicesContent {
  title: string;
  button_text: string;
  service1_title: string;
  service1_description: string;
  service1_icon: string;
  service2_title: string;
  service2_description: string;
  service2_icon: string;
  service3_title: string;
  service3_description: string;
  service3_icon: string;
  service4_title: string;
  service4_description: string;
  service4_icon: string;
  service5_title: string;
  service5_description: string;
  service5_icon: string;
  service6_title: string;
  service6_description: string;
  service6_icon: string;
}

const props = defineProps<{
  content: ServicesContent;
}>();

const bookingModalOpen = ref(false);

const openBookingModal = () => {
  bookingModalOpen.value = true;
};

const closeBookingModal = () => {
  bookingModalOpen.value = false;
};

// Generate the services array from the content prop
const services = computed(() => [
  {
    id: 1,
    title: props.content.service1_title,
    description: props.content.service1_description,
    icon: props.content.service1_icon
  },
  {
    id: 2,
    title: props.content.service2_title,
    description: props.content.service2_description,
    icon: props.content.service2_icon
  },
  {
    id: 3,
    title: props.content.service3_title,
    description: props.content.service3_description,
    icon: props.content.service3_icon
  },
  {
    id: 4,
    title: props.content.service4_title,
    description: props.content.service4_description,
    icon: props.content.service4_icon
  },
  {
    id: 5,
    title: props.content.service5_title,
    description: props.content.service5_description,
    icon: props.content.service5_icon
  },
  {
    id: 6,
    title: props.content.service6_title,
    description: props.content.service6_description,
    icon: props.content.service6_icon
  }
]);
</script>

<template>
  <Layout>
    <div class="container mx-auto py-12 px-4">
      <h1 class="text-4xl font-bold text-center mb-8">{{ content.title }}</h1>
      
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
          {{ content.button_text }}
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