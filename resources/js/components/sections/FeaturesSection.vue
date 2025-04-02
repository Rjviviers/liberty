<script setup lang="ts">
// Define the props interface
interface FeaturesContent {
  title: string;
  image: string;
  cta_title: string;
  cta_description: string;
  cta_button_text: string;
  feature1_title: string;
  feature1_description: string;
  feature1_icon: string;
  feature2_title: string;
  feature2_description: string;
  feature2_icon: string;
  feature3_title: string;
  feature3_description: string;
  feature3_icon: string;
  feature4_title: string;
  feature4_description: string;
  feature4_icon: string;
}

defineProps<{
  content: FeaturesContent;
}>();

// Generate the features array from the content prop
const features = [
  {
    id: 1,
    title: '',
    description: '',
    icon: ''
  },
  {
    id: 2,
    title: '',
    description: '',
    icon: ''
  },
  {
    id: 3,
    title: '',
    description: '',
    icon: ''
  },
  {
    id: 4,
    title: '',
    description: '',
    icon: ''
  }
];

// Update the features array with the prop data
features[0].title = content.feature1_title;
features[0].description = content.feature1_description;
features[0].icon = content.feature1_icon;

features[1].title = content.feature2_title;
features[1].description = content.feature2_description;
features[1].icon = content.feature2_icon;

features[2].title = content.feature3_title;
features[2].description = content.feature3_description;
features[2].icon = content.feature3_icon;

features[3].title = content.feature4_title;
features[3].description = content.feature4_description;
features[3].icon = content.feature4_icon;
</script>

<template>
  <section class="features-section relative overflow-hidden py-16 md:py-24 lg:py-32">
    <!-- Background Effects -->
    <div class="absolute inset-0 grid-pattern opacity-10 dark:opacity-5"></div>
    <div class="blob blob-3"></div>
    
    <div class="container mx-auto px-4 relative z-10">
      <h2 class="fade-in gradient-text text-4xl sm:text-5xl lg:text-6xl font-extrabold text-center mb-16">
        {{ content.title }}
      </h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="(feature, index) in features" :key="index" class="fade-in feature-card">
          <div class="icon-container">
            <i :class="['fas', feature.icon]" class="text-4xl"></i>
          </div>
          <h3 class="text-xl font-bold mt-4">{{ feature.title }}</h3>
          <p class="text-gray-600 dark:text-gray-400 mt-2">{{ feature.description }}</p>
        </div>
      </div>
      
      <div class="rounded-lg overflow-hidden shadow-lg animate-slide-left">
        <img :src="content.image" alt="Biokinetic Therapy" class="w-full h-full object-cover min-h-[300px]">
      </div>
      
      <div class="features-cta p-8 rounded-lg">
        <div class="text-center">
          <h3 class="text-2xl font-semibold mb-4 text-text-color">{{ content.cta_title }}</h3>
          <p class="text-text-light mb-6">{{ content.cta_description }}</p>
          <button class="bg-secondary-color hover:bg-secondary-dark text-white px-6 py-3 rounded-md transition duration-300">
            {{ content.cta_button_text }}
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.features-cta {
  background-color: var(--secondary-light);
  color: var(--text-color);
}

@media (prefers-color-scheme: dark) {
  .features-cta {
    background-color: var(--bg-light);
  }
}

body[class*="theme-dark"] .features-cta {
  background-color: var(--bg-light);
  border: 1px solid var(--border-color);
}
</style> 