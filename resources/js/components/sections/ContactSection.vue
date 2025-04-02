<script setup lang="ts">
// Event for opening booking modal
const emit = defineEmits(['open-booking']);

const openBookingModal = () => {
  emit('open-booking');
};
</script>

<template>
  <section id="contact" class="py-12 md:py-16 lg:py-20 bg-bg-light">
    <div class="container mx-auto px-6 md:px-8 lg:px-12 max-w-7xl">
      <h2 class="fade-in gradient-text text-4xl sm:text-5xl lg:text-6xl font-extrabold text-center mb-6">
        Contact Us
      </h2>
      
      <p class="text-center !text-center mx-auto text-text-light dark:text-gray-400 text-lg max-w-3xl mb-16">
        Get in touch with us to schedule an appointment or learn more about our biokinetic therapy services.
      </p>
      
      <div class="grid md:grid-cols-2 gap-8 flex-row-section h-full">
        <div class="animate-slide-right section-image-container rounded-lg overflow-hidden shadow-xl perspective-container transform transition-all duration-500 hover:scale-[1.02] h-full">
          <div class="relative h-full w-full overflow-hidden rounded-lg flex">
            <!-- Frame corners -->
            <div class="frame-corner top-left"></div>
            <div class="frame-corner top-right"></div>
            <div class="frame-corner bottom-left"></div>
            <div class="frame-corner bottom-right"></div>
            
            <!-- Glow effect -->
            <div class="absolute -inset-1 glow-effect"></div>
            
            <iframe 
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3590.1408923395064!2d28.220775815028153!3d-25.8959861830668!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e956434d7b6a63f%3A0x1cd2d6863ca2b01a!2sJonie%20St%2C%20Annlin%2C%20Pretoria%2C%200182!5e0!3m2!1sen!2sza!4v1623936533253!5m2!1sen!2sza" 
              class="w-full h-full relative z-10" 
              style="border:0; min-height: 500px;" 
              allowfullscreen="true" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
        </div>
        
        <div class="animate-slide-left">
          <h3 class="text-2xl font-bold mb-4 text-text-color dark:text-gray-200">Get in Touch</h3>
          <p class="mb-6 text-text-light dark:text-gray-400">We're here to answer your questions and address your healthcare needs. Reach out to us through any of the following channels or visit our facility during office hours.</p>
          
          <div class="space-y-6">
            <div class="flex items-start">
              <div class="text-primary-color mr-4 mt-1">
                <i class="fas fa-map-marker-alt text-xl"></i>
              </div>
              <div>
                <h4 class="font-semibold text-text-color dark:text-gray-200">Address</h4>
                <p class="text-text-light dark:text-gray-400">4 Jonie street, Annlin, Pretoria</p>
              </div>
            </div>
            
            <div class="flex items-start">
              <div class="text-primary-color mr-4 mt-1">
                <i class="fas fa-phone text-xl"></i>
              </div>
              <div>
                <h4 class="font-semibold text-text-color dark:text-gray-200">Phone</h4>
                <p class="text-text-light dark:text-gray-400">078 393 2622</p>
              </div>
            </div>
            
            <div class="flex items-start">
              <div class="text-primary-color mr-4 mt-1">
                <i class="fas fa-envelope text-xl"></i>
              </div>
              <div>
                <h4 class="font-semibold text-text-color dark:text-gray-200">Email</h4>
                <p class="text-text-light dark:text-gray-400">daniedevilliersbio@gmail.com</p>
              </div>
            </div>
            
            <div class="flex items-start">
              <div class="text-primary-color mr-4 mt-1">
                <i class="fas fa-clock text-xl"></i>
              </div>
              <div>
                <h4 class="font-semibold text-text-color dark:text-gray-200">Hours</h4>
                <p class="text-text-light dark:text-gray-400">Monday - Friday: 8:00 AM - 6:00 PM</p>
                <p class="text-text-light dark:text-gray-400">Saturday: 9:00 AM - 1:00 PM</p>
                <p class="text-text-light dark:text-gray-400">Sunday: Closed</p>
              </div>
            </div>
          </div>
          
          <div class="mt-8">
            <button 
              @click="openBookingModal"
              class="bg-secondary-color hover:bg-secondary-dark text-white px-8 py-4 rounded-md transition duration-300 transform hover:scale-105 hover:shadow-lg flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-secondary-light focus:ring-offset-2"
            >
              <i class="fas fa-calendar-check mr-2"></i>
              Schedule a Consultation
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.gradient-text {
  background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  width: 100%;
}

.frame-corner {
  position: absolute;
  width: 20px;
  height: 20px;
  border-width: 3px;
  border-color: var(--primary-color);
  z-index: 6;
}

.top-left {
  top: -5px;
  left: -5px;
  border-top-style: solid;
  border-left-style: solid;
  border-bottom-style: none;
  border-right-style: none;
  border-top-left-radius: 8px;
}

.top-right {
  top: -5px;
  right: -5px;
  border-top-style: solid;
  border-right-style: solid;
  border-bottom-style: none;
  border-left-style: none;
  border-top-right-radius: 8px;
}

.bottom-left {
  bottom: -5px;
  left: -5px;
  border-bottom-style: solid;
  border-left-style: solid;
  border-top-style: none;
  border-right-style: none;
  border-bottom-left-radius: 8px;
}

.bottom-right {
  bottom: -5px;
  right: -5px;
  border-bottom-style: solid;
  border-right-style: solid;
  border-top-style: none;
  border-left-style: none;
  border-bottom-right-radius: 8px;
}

.glow-effect {
  background: linear-gradient(
    135deg,
    rgba(var(--primary-rgb), 0.6),
    rgba(var(--secondary-rgb), 0.6)
  );
  border-radius: 24px;
  filter: blur(20px);
  opacity: 0.3;
  z-index: -1;
}

.perspective-container {
  perspective: 1000px;
  position: relative;
}

.section-image-container {
  transform-style: preserve-3d;
  overflow: hidden;
  min-height: 550px;
  display: flex;
  height: 100%;
}

@media (max-width: 768px) {
  .section-image-container {
    min-height: 400px;
  }
}

.flex-row-section {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  align-items: stretch;
  gap: 2rem;
}

@media (min-width: 768px) {
  .flex-row-section {
    grid-template-columns: 3fr 2fr;
    gap: 3rem;
  }
}
</style>