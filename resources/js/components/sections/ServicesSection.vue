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
  <section id="services" class="py-16">
    <div class="container mx-auto px-4">
      <h2 class="section-title">{{ content.title }}</h2>
      
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 gap-y-8">
        <div 
          v-for="service in services" 
          :key="service.id" 
          class="service-card p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg hover:transform hover:-translate-y-2 animate-fade-in"
        >
          <div class="text-primary-color text-4xl mb-4">
            <i :class="['fas', service.icon]"></i>
          </div>
          <h3 class="text-xl font-semibold mb-3 text-text-color">{{ service.title }}</h3>
          <p class="service-text">{{ service.description }}</p>
        </div>
      </div>
      
      <div class="text-center mt-12">
        <button class="bg-primary-color hover:bg-primary-dark text-white px-6 py-3 rounded-md transition duration-300">
          {{ content.button_text }}
        </button>
      </div>
    </div>
  </section>
</template>

<style scoped>
.service-card {
  background-color: var(--bg-color);
  border: 1px solid var(--border-color);
}

.service-text {
  color: var(--text-light);
}
</style> 