<script setup lang="ts">
import Layout from '@/layouts/DefaultLayout.vue';
import BookingModal from '@/components/BookingModal.vue';
import { ref } from 'vue';

const bookingModalOpen = ref(false);
const formSubmitted = ref(false);
const formError = ref(false);

const form = ref({
  name: '',
  email: '',
  phone: '',
  subject: '',
  message: ''
});

const openBookingModal = () => {
  bookingModalOpen.value = true;
};

const closeBookingModal = () => {
  bookingModalOpen.value = false;
};

const submitForm = () => {
  // In a real implementation, you would have API call here
  // For now, we'll just simulate a successful submission
  
  try {
    // Reset errors
    formError.value = false;
    
    // Simulate API call
    setTimeout(() => {
      formSubmitted.value = true;
      form.value = {
        name: '',
        email: '',
        phone: '',
        subject: '',
        message: ''
      };
    }, 500);
  } catch (error) {
    formError.value = true;
  }
};
</script>

<template>
  <Layout>
    <div class="container mx-auto py-12 px-4">
      <h1 class="text-4xl font-bold text-center mb-8">Contact Us</h1>
      
      <div class="grid md:grid-cols-2 gap-8 mb-12">
        <div>
          <h2 class="text-2xl font-semibold mb-4">Get in Touch</h2>
          <p class="mb-6">We're here to answer your questions and address your concerns. Fill out the form or use the contact information provided to reach out to us.</p>
          
          <div class="mb-6">
            <h3 class="text-xl font-semibold mb-3">Contact Information</h3>
            <div class="flex items-start mb-3">
              <i class="fas fa-map-marker-alt text-primary-color mt-1 mr-3"></i>
              <div>
                <p>123 Healthcare Drive</p>
                <p>New York, NY 10001</p>
              </div>
            </div>
            <div class="flex items-center mb-3">
              <i class="fas fa-phone text-primary-color mr-3"></i>
              <p>(555) 123-4567</p>
            </div>
            <div class="flex items-center mb-3">
              <i class="fas fa-envelope text-primary-color mr-3"></i>
              <p>info@libertyhealthcare.com</p>
            </div>
          </div>
          
          <div>
            <h3 class="text-xl font-semibold mb-3">Office Hours</h3>
            <div class="grid grid-cols-2 gap-2">
              <p>Monday - Friday:</p>
              <p>8:00 AM - 6:00 PM</p>
              <p>Saturday:</p>
              <p>9:00 AM - 1:00 PM</p>
              <p>Sunday:</p>
              <p>Closed</p>
            </div>
          </div>
        </div>
        
        <div>
          <div v-if="formSubmitted" class="bg-success-color bg-opacity-10 border border-success-color text-success-color p-4 rounded-md mb-6">
            <p>Thank you for your message! We'll get back to you as soon as possible.</p>
          </div>
          
          <div v-if="formError" class="bg-error-color bg-opacity-10 border border-error-color text-error-color p-4 rounded-md mb-6">
            <p>There was an error submitting your message. Please try again later.</p>
          </div>
          
          <form @submit.prevent="submitForm" v-if="!formSubmitted">
            <div class="mb-4">
              <label class="block text-gray-700 mb-2" for="name">Your Name*</label>
              <input 
                v-model="form.name" 
                type="text" 
                id="name" 
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-color"
                required
              >
            </div>
            
            <div class="mb-4">
              <label class="block text-gray-700 mb-2" for="email">Your Email*</label>
              <input 
                v-model="form.email" 
                type="email" 
                id="email" 
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-color"
                required
              >
            </div>
            
            <div class="mb-4">
              <label class="block text-gray-700 mb-2" for="phone">Phone Number</label>
              <input 
                v-model="form.phone" 
                type="tel" 
                id="phone" 
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-color"
              >
            </div>
            
            <div class="mb-4">
              <label class="block text-gray-700 mb-2" for="subject">Subject*</label>
              <input 
                v-model="form.subject" 
                type="text" 
                id="subject" 
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-color"
                required
              >
            </div>
            
            <div class="mb-6">
              <label class="block text-gray-700 mb-2" for="message">Message*</label>
              <textarea 
                v-model="form.message" 
                id="message" 
                rows="5" 
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-color"
                required
              ></textarea>
            </div>
            
            <div class="flex justify-between items-center">
              <button 
                type="submit"
                class="bg-primary-color hover:bg-primary-dark text-white px-6 py-3 rounded-md transition duration-300"
              >
                Send Message
              </button>
              
              <button 
                type="button"
                @click="openBookingModal"
                class="text-primary-color hover:text-primary-dark underline"
              >
                Or schedule an appointment
              </button>
            </div>
          </form>
          
          <div v-if="formSubmitted" class="text-center mt-6">
            <button 
              @click="formSubmitted = false"
              class="bg-primary-color hover:bg-primary-dark text-white px-6 py-3 rounded-md transition duration-300"
            >
              Send Another Message
            </button>
          </div>
        </div>
      </div>
      
      <div class="h-80 bg-gray-200 rounded-lg">
        <!-- Placeholder for Google Map -->
        <div class="w-full h-full flex items-center justify-center">
          <p class="text-gray-500">Map will be displayed here</p>
        </div>
      </div>
    </div>
    
    <!-- Booking Modal -->
    <BookingModal 
      :is-open="bookingModalOpen" 
      @close="closeBookingModal" 
    />
  </Layout>
</template> 