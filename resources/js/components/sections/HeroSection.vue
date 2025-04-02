<script setup lang="ts">
interface HeroContent {
  heading: string;
  subheading: string;
  description: string;
  image: string;
  button_text: string;
  admin_button_text: string;
}

defineProps<{
  content: HeroContent;
}>();

const emit = defineEmits<{
  (e: 'open-booking'): void;
}>();
</script>

<template>
  <section id="home" class="relative py-20 md:py-32 overflow-hidden bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
      <!-- Text content -->
      <div class="md:w-1/2 mb-10 md:mb-0 text-center md:text-left">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6">
          {{ content.heading }}
        </h1>
        <p class="text-xl font-medium text-gray-700 dark:text-gray-300 mb-4">
          {{ content.subheading }}
        </p>
        <p class="text-lg text-gray-700 dark:text-gray-300 mb-8">
          {{ content.description }}
        </p>
        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 justify-center md:justify-start">
          <button @click="emit('open-booking')" class="btn btn-primary">
            {{ content.button_text }}
          </button>
          <a href="/admin/login" class="btn btn-outline">
            {{ content.admin_button_text }}
          </a>
        </div>
      </div>
      
      <!-- Image -->
      <div class="md:w-1/2">
        <img 
          :src="content.image" 
          alt="Danie De Villiers - Professional Biokineticist" 
          class="w-full h-auto mx-auto rounded"
        >
      </div>
    </div>
  </section>
</template>

<style scoped>
.hero {
  padding: 120px 5% 80px;
  background-color: var(--bg-light);
  min-height: 80vh;
  display: flex;
  align-items: center;
}

.hero-container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 3rem;
  max-width: 1200px;
  margin: 0 auto;
  align-items: center;
}

.hero-content {
  max-width: 600px;
}

.hero-content h1 {
  font-size: 2.8rem;
  font-weight: 700;
  color: var(--primary-color);
  margin-bottom: 1rem;
  line-height: 1.2;
}

.hero-content h2 {
  font-size: 1.8rem;
  font-weight: 500;
  color: var(--secondary-color);
  margin-bottom: 1.5rem;
}

.hero-content p {
  font-size: 1.1rem;
  margin-bottom: 2rem;
  line-height: 1.6;
  color: var(--text-color);
}

.cta-buttons {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.cta-btn {
  text-decoration: none;
  padding: 0.8rem 2rem;
  border-radius: 30px;
  font-weight: 600;
  transition: all 0.3s ease;
  display: inline-block;
}

.cta-btn.primary {
  background-color: var(--primary-color);
  color: white;
}

.cta-btn.primary:hover {
  background-color: var(--primary-dark);
  transform: translateY(-3px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.cta-btn.secondary {
  background-color: transparent;
  color: var(--primary-color);
  border: 2px solid var(--primary-color);
}

.cta-btn.secondary:hover {
  background-color: var(--primary-light);
  transform: translateY(-3px);
}

.hero-image {
  position: relative;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.hero-image img {
  max-width: 100%;
  height: auto;
  /* No border radius or shadow */
}

@media (max-width: 768px) {
  .hero-container {
    grid-template-columns: 1fr;
    gap: 2rem;
  }

  .hero-content {
    text-align: center;
    margin: 0 auto;
  }

  .hero-content h1 {
    font-size: 2.2rem;
  }

  .hero-content h2 {
    font-size: 1.5rem;
  }

  .cta-buttons {
    justify-content: center;
  }

  .hero-image {
    order: -1;
  }
}
</style> 