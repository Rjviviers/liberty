<script setup lang="ts">
// Event for opening booking modal
const emit = defineEmits(['open-booking']);

const openBookingModal = () => {
  emit('open-booking');
};
</script>

<template>
  <section id="contact" class="py-16 bg-bg-light">
    <div class="container mx-auto px-4">
      <h2 class="section-title">Contact Us</h2>
      
      <div class="grid md:grid-cols-2 gap-8">
        <div class="animate-slide-right">
          <h3 class="text-2xl font-semibold mb-4">Get in Touch</h3>
          <p class="mb-6">We're here to answer your questions and address your healthcare needs. Reach out to us through any of the following channels or visit our facility during office hours.</p>
          
          <div class="mb-6">
            <div class="flex items-start mb-4">
              <div class="text-primary-color mr-4 mt-1">
                <i class="fas fa-map-marker-alt text-xl"></i>
              </div>
              <div>
                <h4 class="font-semibold">Address</h4>
                <p>4 Jonie street, Annlin, Pretoria</p>
              </div>
            </div>
            
            <div class="flex items-start mb-4">
              <div class="text-primary-color mr-4 mt-1">
                <i class="fas fa-phone text-xl"></i>
              </div>
              <div>
                <h4 class="font-semibold">Phone</h4>
                <p>078 393 2622</p>
              </div>
            </div>
            
            <div class="flex items-start mb-4">
              <div class="text-primary-color mr-4 mt-1">
                <i class="fas fa-envelope text-xl"></i>
              </div>
              <div>
                <h4 class="font-semibold">Email</h4>
                <p>daniedevilliersbio@gmail.com</p>
              </div>
            </div>
            
            <div class="flex items-start">
              <div class="text-primary-color mr-4 mt-1">
                <i class="fas fa-clock text-xl"></i>
              </div>
              <div>
                <h4 class="font-semibold">Hours</h4>
                <p>Monday - Friday: 8:00 AM - 5:00 PM</p>
                <p>Saturday: 9:00 AM - 1:00 PM</p>
                <p>Sunday: Closed</p>
              </div>
            </div>
          </div>
          
          <button @click="openBookingModal" class="btn btn-primary">
            Book a Consultation
          </button>
        </div>
        
        <div class="contact-form bg-white p-8 rounded-lg shadow-lg animate-slide-left">
          <h3 class="text-2xl font-semibold mb-4">Send a Message</h3>
          
          <form>
            <div class="grid md:grid-cols-2 gap-4 mb-4">
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-color">
              </div>
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-color">
              </div>
            </div>
            
            <div class="mb-4">
              <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
              <input type="text" id="subject" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-color">
            </div>
            
            <div class="mb-4">
              <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
              <textarea id="message" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-color"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary w-full">
              Send Message
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>
</template> 