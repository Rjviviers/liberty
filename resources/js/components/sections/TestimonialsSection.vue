<script setup lang="ts">
interface Testimonial {
  id: number;
  name: string;
  detail: string;
  text: string;
}

interface TestimonialsContent {
  title: string;
  view_all_text: string;
  avatar1: string;
  avatar2: string;
  avatar3: string;
}

const props = defineProps<{
  testimonials: Testimonial[];
  content: TestimonialsContent;
}>();

// Get avatar URLs from the content props
const getAvatarUrl = (index: number) => {
  const avatars = [
    props.content.avatar1,
    props.content.avatar2,
    props.content.avatar3
  ];
  return avatars[index % avatars.length] || '';
};
</script>

<template>
  <section id="testimonials" class="testimonials-section relative overflow-hidden py-12 md:py-16 lg:py-20">
    <!-- Background Effects -->
    <div class="absolute inset-0 noise-bg bg-gradient-to-br from-gray-50/80 to-white dark:from-gray-900/90 dark:to-gray-800/90"></div>
    
    <div class="container mx-auto px-6 md:px-8 lg:px-12 max-w-7xl relative z-10">
      <h2 class="fade-in gradient-text text-4xl sm:text-5xl lg:text-6xl font-extrabold text-center mb-6">
        {{ content.title }}
      </h2>
      
      <p class="text-center !text-center mx-auto text-text-light dark:text-gray-400 text-lg max-w-3xl mb-16">
        See what our clients have to say about their experience with our biokinetic therapy services.
      </p>
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="(testimonial, index) in testimonials" :key="testimonial.id" class="fade-in testimonial-card p-6 rounded-lg shadow-md transition-all duration-300 transform hover:-translate-y-2 hover:shadow-lg">
          <div class="avatar-container mx-auto w-20 h-20 mb-4 overflow-hidden rounded-full border-2 border-primary-color/20">
            <img :src="getAvatarUrl(index)" :alt="testimonial.name" class="rounded-full w-full h-full object-cover">
          </div>
          <p class="testimonial-text text-center italic mb-4 text-text-light dark:text-gray-400">"{{ testimonial.text }}"</p>
          <div class="text-center">
            <p class="testimonial-name text-lg font-bold text-text-color dark:text-gray-200">{{ testimonial.name }}</p>
            <p class="testimonial-detail text-sm text-text-light dark:text-gray-400">{{ testimonial.detail }}</p>
          </div>
        </div>
      </div>
      
      <div class="text-center mt-12" v-if="testimonials.length > 0">
        <a href="/testimonials" class="bg-secondary-color hover:bg-secondary-dark text-white px-8 py-4 rounded-md transition duration-300 transform hover:scale-105 hover:shadow-lg inline-flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-secondary-light focus:ring-offset-2">
          <i class="fas fa-comment-dots mr-2"></i>
          {{ content.view_all_text }}
        </a>
      </div>
    </div>
  </section>
</template>

<style scoped>
.testimonial-card {
  background-color: var(--bg-card);
  color: var(--text-color);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.testimonial-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.testimonial-text {
  color: var(--text-color);
}

.testimonial-name {
  color: var(--text-color);
}

.testimonial-detail {
  color: var(--text-muted);
}

.avatar-container {
  /* No border */
}

.gradient-text {
  background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  width: 100%;
}
</style> 