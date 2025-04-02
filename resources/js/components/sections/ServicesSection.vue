<script setup lang="ts">
// No props or emits needed for this component

const services = [
  {
    id: 1,
    title: 'Rehabilitation',
    description: 'Customized biokinetic rehabilitation for injuries, post-surgery recovery, and chronic conditions to restore optimal movement.',
    icon: 'fa-walking'
  },
  {
    id: 2,
    title: 'Sports Performance',
    description: 'Specialized training programs to enhance athletic performance, prevent injuries, and optimize recovery for athletes.',
    icon: 'fa-running'
  },
  {
    id: 3,
    title: 'Chronic Disease Management',
    description: 'Exercise therapy regimens for managing chronic conditions such as diabetes, hypertension, and cardiovascular disease.',
    icon: 'fa-heartbeat'
  },
  {
    id: 4,
    title: 'Postural Assessment',
    description: 'Comprehensive analysis of body alignment and posture to identify imbalances and create corrective programs.',
    icon: 'fa-user-check'
  },
  {
    id: 5,
    title: 'Orthopedic Therapy',
    description: 'Specialized treatment for musculoskeletal issues including joint pain, muscle strains, and mobility limitations.',
    icon: 'fa-bone'
  },
  {
    id: 6,
    title: 'Wellness Programs',
    description: 'Personalized exercise plans focused on improving overall health, strength, flexibility, and quality of life.',
    icon: 'fa-dumbbell'
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
          View All Services
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