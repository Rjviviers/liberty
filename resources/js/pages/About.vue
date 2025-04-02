<script setup lang="ts">
import Layout from '@/layouts/DefaultLayout.vue';
import BookingModal from '@/components/BookingModal.vue';
import { ref } from 'vue';

interface AboutContent {
  title: string;
  subtitle: string;
  paragraph1: string;
  paragraph2: string;
  image: string;
  years_experience: string;
  experience_text: string;
  highlight1_title: string;
  highlight1_icon: string;
  highlight2_title: string;
  highlight2_icon: string;
  highlight3_title: string;
  highlight3_icon: string;
  highlight4_title: string;
  highlight4_icon: string;
}

defineProps<{
  aboutContent: AboutContent;
}>();

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
    <section id="about" class="py-16 bg-bg-light dark:bg-gray-900">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-10 text-text-color dark:text-white">
          {{ aboutContent.title }}
        </h2>
        
        <div class="grid md:grid-cols-2 gap-8 items-center">
          <div class="animate-slide-right">
            <h3 class="text-2xl font-semibold mb-4 text-text-color dark:text-gray-200">
              {{ aboutContent.subtitle }}
            </h3>
            <p class="mb-4 text-text-color dark:text-gray-300">
              {{ aboutContent.paragraph1 }}
            </p>
            <p class="mb-4 text-text-color dark:text-gray-300">
              {{ aboutContent.paragraph2 }}
            </p>
            
            <div class="grid grid-cols-2 gap-4 mt-6">
              <div class="p-4 rounded-lg shadow-sm text-center bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <div class="text-primary-color text-3xl mb-2">
                  <i :class="aboutContent.highlight1_icon"></i>
                </div>
                <h4 class="font-semibold text-text-color dark:text-gray-200">
                  {{ aboutContent.highlight1_title }}
                </h4>
              </div>
              
              <div class="p-4 rounded-lg shadow-sm text-center bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <div class="text-primary-color text-3xl mb-2">
                  <i :class="aboutContent.highlight2_icon"></i>
                </div>
                <h4 class="font-semibold text-text-color dark:text-gray-200">
                  {{ aboutContent.highlight2_title }}
                </h4>
              </div>
              
              <div class="p-4 rounded-lg shadow-sm text-center bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <div class="text-primary-color text-3xl mb-2">
                  <i :class="aboutContent.highlight3_icon"></i>
                </div>
                <h4 class="font-semibold text-text-color dark:text-gray-200">
                  {{ aboutContent.highlight3_title }}
                </h4>
              </div>
              
              <div class="p-4 rounded-lg shadow-sm text-center bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <div class="text-primary-color text-3xl mb-2">
                  <i :class="aboutContent.highlight4_icon"></i>
                </div>
                <h4 class="font-semibold text-text-color dark:text-gray-200">
                  {{ aboutContent.highlight4_title }}
                </h4>
              </div>
            </div>
            
            <div class="mt-8 text-center md:text-left">
              <button 
                @click="openBookingModal"
                class="btn btn-primary px-6 py-3 rounded-md transition duration-300"
              >
                Schedule a Consultation
              </button>
            </div>
          </div>
          
          <div class="animate-slide-left">
            <div class="relative">
              <div class="bg-primary-color w-full h-64 md:h-80 rounded-lg overflow-hidden shadow-lg">
                <img :src="aboutContent.image" alt="About Danie de Villiers" class="w-full h-full object-cover">
              </div>
              <div class="p-6 rounded-lg shadow-lg max-w-xs mx-auto md:mx-0 md:absolute md:-bottom-10 md:-left-10 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-4">
                  <div class="text-secondary-color text-4xl">
                    <i class="fas fa-award"></i>
                  </div>
                  <div>
                    <h4 class="font-bold text-lg text-text-color dark:text-gray-200">
                      {{ aboutContent.years_experience }} Years
                    </h4>
                    <p class="text-sm text-text-light dark:text-gray-400">
                      {{ aboutContent.experience_text }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Booking Modal -->
    <BookingModal 
      :is-open="bookingModalOpen" 
      @close="closeBookingModal" 
    />
  </Layout>
</template> 