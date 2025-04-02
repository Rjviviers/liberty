<script setup lang="ts">
// Define the props interface
interface FeaturesContent {
  title: string;
  image: string;
  cta_title: string;
  cta_description: string;
  cta_button_text: string;
  feature1_title: string;
  feature1_description: string;
  feature1_icon: string;
  feature2_title: string;
  feature2_description: string;
  feature2_icon: string;
  feature3_title: string;
  feature3_description: string;
  feature3_icon: string;
  feature4_title: string;
  feature4_description: string;
  feature4_icon: string;
}

const props = defineProps<{
  content: FeaturesContent;
}>();

// Event for opening booking modal
const emit = defineEmits(['open-booking']);

const openBookingModal = () => {
  emit('open-booking');
};

// Generate the features array from the content prop
const features = [
  {
    id: 1,
    title: props.content.feature1_title,
    description: props.content.feature1_description,
    icon: props.content.feature1_icon
  },
  {
    id: 2,
    title: props.content.feature2_title,
    description: props.content.feature2_description,
    icon: props.content.feature2_icon
  },
  {
    id: 3,
    title: props.content.feature3_title,
    description: props.content.feature3_description,
    icon: props.content.feature3_icon
  },
  {
    id: 4,
    title: props.content.feature4_title,
    description: props.content.feature4_description,
    icon: props.content.feature4_icon
  }
];
</script>

<template>
  <section id="features" class="features-section relative overflow-hidden py-12 md:py-16 lg:py-20">
    <!-- Background Effects -->
    <div class="absolute inset-0 grid-pattern opacity-10 dark:opacity-5"></div>
    <div class="blob blob-3"></div>
    <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-gradient-to-br from-primary-light to-transparent opacity-20 rounded-full blur-3xl transform translate-x-1/4 -translate-y-1/4"></div>
    
    <div class="container mx-auto px-6 md:px-8 lg:px-12 relative z-10 max-w-7xl">
      <h2 class="fade-in gradient-text text-4xl sm:text-5xl lg:text-6xl font-extrabold text-center mb-6">
        {{ content.title }}
      </h2>
      
      <p class="text-center !text-center mx-auto text-text-light dark:text-gray-400 text-lg max-w-3xl mb-16">
        Choose Danie de Villiers for professional biokinetic care that combines expertise, personalization, and a holistic approach to your wellness journey.
      </p>
      
      <!-- Feature Cards Grid -->
      <div class="feature-cards-container mx-auto max-w-6xl mb-20">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
          <div v-for="(feature, index) in features" :key="index" 
              class="feature-card p-8 rounded-lg transform transition-all duration-300 hover:-translate-y-2 hover:shadow-lg flex flex-col"
              :class="{'animate-slide-right': index % 2 === 0, 'animate-slide-left': index % 2 === 1}">
            <div class="flex items-center justify-center mb-4">
              <div class="icon-container relative flex items-center justify-center w-16 h-16 rounded-full">
                <i :class="['fas', feature.icon]" class="text-4xl text-primary-color z-10" aria-hidden="true"></i>
              </div>
            </div>
            <h3 class="text-xl font-bold mb-3 text-text-color dark:text-gray-200 text-center">{{ feature.title }}</h3>
            <p class="text-text-light dark:text-gray-400 text-center">{{ feature.description }}</p>
          </div>
        </div>
      </div>
      
      <div class="features-cta p-8 md:p-12 rounded-xl shadow-md mt-16 animate-fade-in">
        <div class="md:flex md:items-center md:justify-between">
          <div class="md:w-3/4 mb-6 md:mb-0">
            <h3 class="text-2xl md:text-3xl font-semibold mb-4 text-text-color dark:text-gray-200">{{ content.cta_title }}</h3>
            <p class="text-text-light dark:text-gray-400 text-lg">{{ content.cta_description }}</p>
          </div>
          <div class="md:w-1/4 flex justify-center md:justify-end">
            <button 
              @click="openBookingModal"
              class="bg-secondary-color hover:bg-secondary-dark text-white px-8 py-4 rounded-md transition duration-300 transform hover:scale-105 hover:shadow-lg flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-secondary-light focus:ring-offset-2"
              aria-label="Open booking modal">
              <i class="fas fa-calendar-check mr-2" aria-hidden="true"></i>
              {{ content.cta_button_text }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.features-cta {
  background-color: var(--secondary-light);
  color: var(--text-color);
  position: relative;
  overflow: hidden;
}

.features-cta::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='currentColor' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
  opacity: 0.1;
}

.feature-cards-container {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.feature-card {
  height: auto;
  display: flex;
  flex-direction: column;
  border: 1px solid transparent;
  background-color: var(--bg-color);
  transition: all 0.3s ease;
  position: relative;
  z-index: 1;
  overflow: hidden;
}

.feature-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 4px;
  background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
  transform: translateY(-100%);
  transition: transform 0.3s ease;
  z-index: -1;
}

.feature-card:hover::before {
  transform: translateY(0);
}

.feature-card:hover {
  border-color: var(--border-color);
  background-color: var(--bg-light);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.icon-container {
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  width: 70px;
  height: 70px;
  border-radius: 50%;
  background-color: var(--bg-light);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
}

.icon-container::after {
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  background-color: var(--primary-light);
  border-radius: 50%;
  z-index: 0;
  top: 0;
  left: 0;
  opacity: 0.1;
  transition: transform 0.3s ease;
}

.feature-card:hover .icon-container {
  transform: scale(1.1);
}

.feature-card:hover .icon-container::after {
  transform: scale(1.2);
  opacity: 0.3;
}

@media (prefers-color-scheme: dark) {
  .features-cta {
    background-color: var(--bg-light);
  }
  
  .feature-card {
    background-color: var(--bg-dark);
  }
  
  .feature-card:hover {
    background-color: var(--bg-light);
  }
}

body[class*="theme-dark"] .features-cta {
  background-color: var(--bg-light);
  border: 1px solid var(--border-color);
}

.gradient-text {
  background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  width: 100%;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.animate-fade-in {
  animation: fadeIn 1s ease;
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
  min-height: 300px;
}

@media (min-width: 640px) {
  .section-image-container {
    min-height: 400px;
  }
}

@media (min-width: 1024px) {
  .section-image-container {
    height: 100%;
    min-height: 450px;
  }
}

.flex-row-section {
  display: grid;
  grid-template-columns: 1fr;
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