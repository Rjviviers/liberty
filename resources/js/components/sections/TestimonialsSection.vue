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
  <section class="testimonials-section relative overflow-hidden py-16 md:py-24 lg:py-32">
    <!-- Background Effects -->
    <div class="absolute inset-0 noise-bg bg-gradient-to-br from-gray-50/80 to-white dark:from-gray-900/90 dark:to-gray-800/90"></div>
    
    <div class="container mx-auto px-4 relative z-10">
      <h2 class="fade-in gradient-text text-4xl sm:text-5xl lg:text-6xl font-extrabold text-center mb-16">
        {{ content.heading }}
      </h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="(testimonial, index) in content.testimonials" :key="index" class="fade-in testimonial-card">
          <div class="avatar-container">
            <img :src="testimonial.avatar" :alt="testimonial.name" class="rounded-full">
          </div>
          <p class="text-gray-600 dark:text-gray-400 mt-4">{{ testimonial.text }}</p>
          <p class="text-lg font-bold mt-4">{{ testimonial.name }}</p>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.testimonial-card {
  background-color: var(--bg-card);
  color: var(--text-color);
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
</style> 