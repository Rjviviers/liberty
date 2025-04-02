<script setup lang="ts">
// No props or emits needed for this component

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
  <section id="services" class="py-16">
    <div class="container mx-auto px-4">
      <h2 class="section-title">Our Services</h2>
      
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 gap-y-8">
        <div 
          v-for="service in services" 
          :key="service.id" 
          class="bg-white p-6 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg hover:transform hover:-translate-y-2 animate-fade-in"
        >
          <div class="text-primary-color text-4xl mb-4">
            <i :class="['fas', service.icon]"></i>
          </div>
          <h3 class="text-xl font-semibold mb-3">{{ service.title }}</h3>
          <p class="text-gray-600">{{ service.description }}</p>
        </div>
      </div>
      
      <div class="text-center mt-12">
        <button class="bg-primary-color hover:bg-primary-dark text-white px-6 py-3 rounded-md transition duration-300">
          View All Services
        </button>
      </div>
    </div>
  </section>
</template> 