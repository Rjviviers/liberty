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
  <section id="testimonials" class="py-16 bg-bg-light">
    <div class="container mx-auto px-4">
      <h2 class="section-title">{{ content.title || 'What Our Patients Say' }}</h2>
      
      <div v-if="testimonials && testimonials.length" class="grid md:grid-cols-3 gap-6">
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
              <img :src="getAvatarUrl(index)" alt="Testimonial avatar" class="w-full h-full object-cover">
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