<script setup lang="ts">
import { computed } from 'vue';

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
  <section id="services" class="py-12 md:py-16 lg:py-20">
    <div class="container mx-auto px-6 md:px-8 lg:px-12 max-w-7xl">
      <h2 class="fade-in gradient-text text-4xl sm:text-5xl lg:text-6xl font-extrabold text-center mb-6">
        {{ content.title }}
      </h2>
      
      <p class="text-center !text-center mx-auto text-text-light dark:text-gray-400 text-lg max-w-3xl mb-16">
        Explore our specialized biokinetic services tailored to address your unique health and wellness needs.
      </p>
      
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 gap-y-8">
        <div 
          v-for="service in services" 
          :key="service.id" 
          class="service-card rounded-lg transform transition-all duration-300 hover:-translate-y-2 hover:shadow-lg flex flex-col"
        >
          <div class="flex items-center justify-center mb-4">
            <div class="icon-container relative flex items-center justify-center w-16 h-16 rounded-full">
              <i :class="['fas', service.icon]" class="text-4xl text-primary-color z-10"></i>
            </div>
          </div>
          <h3 class="text-xl font-bold mb-3 text-text-color dark:text-gray-200 text-center">{{ service.title }}</h3>
          <p class="text-text-light dark:text-gray-400 text-center">{{ service.description }}</p>
        </div>
      </div>
      
      <div class="text-center mt-12">
        <button class="bg-secondary-color hover:bg-secondary-dark text-white px-8 py-4 rounded-md transition duration-300 transform hover:scale-105 hover:shadow-lg flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-secondary-light focus:ring-offset-2 mx-auto">
          <i class="fas fa-arrow-right mr-2"></i>
          {{ content.button_text }}
        </button>
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

.service-card {
  height: auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  border: 1px solid var(--border-color);
  background-color: var(--bg-color);
  transition: all 0.3s ease;
  position: relative;
  z-index: 1;
  overflow: hidden;
  padding: 1.5rem;
}

.service-card:hover {
  border-color: var(--primary-color);
  transform: translateY(-8px);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1), 
              0 0 15px rgba(var(--primary-rgb), 0.1);
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

.service-card:hover .icon-container {
  transform: scale(1.1);
}

.service-card:hover .icon-container::after {
  transform: scale(1.2);
  opacity: 0.3;
}
</style> 