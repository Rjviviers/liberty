<script setup lang="ts">
interface AboutContent {
  title: string;
  subtitle: string;
  paragraph1: string;
  paragraph2: string;
  image: string;
  years_experience: string;
  experience_text: string;
  highlight1_title: string;
  highlight1_icon: string;
  highlight2_title: string;
  highlight2_icon: string;
  highlight3_title: string;
  highlight3_icon: string;
  highlight4_title: string;
  highlight4_icon: string;
}

defineProps<{
  content: AboutContent;
}>();
</script>

<template>
  <section class="about-section relative overflow-hidden py-16 md:py-24 lg:py-32">
    <!-- Background Effects -->
    <div class="absolute inset-0 noise-bg bg-gradient-to-br from-gray-50/80 to-white dark:from-gray-900/90 dark:to-gray-800/90"></div>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    
    <div class="container mx-auto px-4 relative z-10">
      <div class="flex flex-col lg:flex-row items-center gap-16">
        <!-- Image Container -->
        <div class="fade-in lg:w-1/2 perspective-container">
          <div class="relative image-container">
            <img :src="content.image" alt="About Us" class="relative z-10 main-image">
            <div class="absolute -inset-2 glow-effect"></div>
          </div>
        </div>
        
        <!-- Text Content -->
        <div class="fade-in lg:w-1/2 space-y-8">
          <h2 class="gradient-text text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight">
            {{ content.title }}
          </h2>
          <p class="text-lg text-gray-600 dark:text-gray-400">
            {{ content.subtitle }}
          </p>
          <p class="text-lg text-gray-600 dark:text-gray-400">
            {{ content.paragraph1 }}
          </p>
          <p class="text-lg text-gray-600 dark:text-gray-400">
            {{ content.paragraph2 }}
          </p>
          
          <div class="grid grid-cols-2 gap-4 mt-6">
            <div class="about-card p-4 rounded-lg shadow-sm text-center">
              <div class="text-primary-color text-3xl mb-2">
                <i :class="content.highlight1_icon"></i>
              </div>
              <h4 class="font-semibold text-text-color">{{ content.highlight1_title }}</h4>
            </div>
            <div class="about-card p-4 rounded-lg shadow-sm text-center">
              <div class="text-primary-color text-3xl mb-2">
                <i :class="content.highlight2_icon"></i>
              </div>
              <h4 class="font-semibold text-text-color">{{ content.highlight2_title }}</h4>
            </div>
            <div class="about-card p-4 rounded-lg shadow-sm text-center">
              <div class="text-primary-color text-3xl mb-2">
                <i :class="content.highlight3_icon"></i>
              </div>
              <h4 class="font-semibold text-text-color">{{ content.highlight3_title }}</h4>
            </div>
            <div class="about-card p-4 rounded-lg shadow-sm text-center">
              <div class="text-primary-color text-3xl mb-2">
                <i :class="content.highlight4_icon"></i>
              </div>
              <h4 class="font-semibold text-text-color">{{ content.highlight4_title }}</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.about-card {
  background-color: var(--bg-color);
  border: 1px solid var(--border-color);
}

.about-badge {
  background-color: var(--bg-color);
  border: 1px solid var(--border-color);
}
</style> 