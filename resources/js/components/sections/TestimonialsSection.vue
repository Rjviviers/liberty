<script setup lang="ts">
interface Testimonial {
  id: number;
  name: string;
  detail: string;
  text: string;
}

// Add avatar URLs for testimonials
const avatarUrls = [
  "https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80",
  "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80",
  "https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=150&q=80"
];

defineProps<{
  testimonials: Testimonial[];
}>();
</script>

<template>
  <section id="testimonials" class="py-16 bg-bg-light">
    <div class="container mx-auto px-4">
      <h2 class="section-title">What Our Patients Say</h2>
      
      <div v-if="testimonials.length" class="grid md:grid-cols-3 gap-6">
        <div 
          v-for="(testimonial, index) in testimonials" 
          :key="testimonial.id" 
          class="testimonial-card p-6 rounded-lg shadow-md animate-fade-in"
        >
          <div class="mb-4 text-secondary-color">
            <i class="fas fa-quote-left text-3xl"></i>
          </div>
          <p class="italic mb-6 testimonial-text">{{ testimonial.text }}</p>
          <div class="flex items-center">
            <div class="w-12 h-12 rounded-full mr-4 overflow-hidden">
              <img :src="avatarUrls[index % 3]" alt="Testimonial avatar" class="w-full h-full object-cover">
            </div>
            <div>
              <h4 class="font-semibold testimonial-name">{{ testimonial.name }}</h4>
              <p class="text-sm testimonial-detail">{{ testimonial.detail }}</p>
            </div>
          </div>
        </div>
      </div>
      
      <div v-else class="text-center p-8 testimonial-card rounded-lg shadow-md">
        <p class="testimonial-text">No testimonials available at the moment.</p>
      </div>
      
      <div class="text-center mt-12">
        <a href="#" class="text-primary-color hover:text-primary-dark underline">
          View All Testimonials
        </a>
      </div>
    </div>
  </section>
</template>

<style scoped>
.testimonial-card {
  background-color: var(--bg-color);
  border: 1px solid var(--border-color);
}

.testimonial-text {
  color: var(--text-color);
}

.testimonial-name {
  color: var(--text-color);
}

.testimonial-detail {
  color: var(--text-light);
}
</style> 