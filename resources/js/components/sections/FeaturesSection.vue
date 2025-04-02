<script setup lang="ts">
// No props or emits needed for this component

const features = [
  {
    id: 1,
    title: 'Patient-Centered Care',
    description: 'Danie prioritizes your unique needs and preferences in every aspect of your biokinetic treatment plan.',
    icon: 'fa-user-check'
  },
  {
    id: 2,
    title: 'Advanced Techniques',
    description: 'Using cutting-edge exercise therapy techniques and equipment for effective rehabilitation and performance enhancement.',
    icon: 'fa-laptop-medical'
  },
  {
    id: 3,
    title: 'Experienced Professional',
    description: 'With over 15 years of experience, Danie brings specialized knowledge in biokinetics to your treatment.',
    icon: 'fa-user-md'
  },
  {
    id: 4,
    title: 'Holistic Approach',
    description: 'Addressing all aspects of your movement and physical wellbeing, not just isolated symptoms or conditions.',
    icon: 'fa-hospital-user'
  }
];
</script>

<template>
  <section id="features" class="py-16">
    <div class="container mx-auto px-4">
      <h2 class="section-title">Why Choose Danie de Villiers</h2>
      
      <div class="grid md:grid-cols-2 gap-8 mb-12">
        <div>
          <div 
            v-for="feature in features" 
            :key="feature.id" 
            class="flex mb-8 animate-slide-right"
          >
            <div class="mr-4 text-primary-color text-3xl">
              <i :class="['fas', feature.icon]"></i>
            </div>
            <div>
              <h3 class="text-xl font-semibold mb-2">{{ feature.title }}</h3>
              <p class="text-gray-600">{{ feature.description }}</p>
            </div>
          </div>
        </div>
        
        <div class="rounded-lg overflow-hidden shadow-lg animate-slide-left">
          <img src="https://images.unsplash.com/photo-1522898467493-49726bf28798?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Biokinetic Therapy" class="w-full h-full object-cover min-h-[300px]">
        </div>
      </div>
      
      <div class="bg-secondary-light p-8 rounded-lg">
        <div class="text-center">
          <h3 class="text-2xl font-semibold mb-4">Ready to experience exceptional biokinetic care?</h3>
          <p class="text-gray-600 mb-6">Schedule your consultation today and take the first step towards better movement and health.</p>
          <button class="bg-secondary-color hover:bg-secondary-dark text-white px-6 py-3 rounded-md transition duration-300">
            Get Started
          </button>
        </div>
      </div>
    </div>
  </section>
</template> 