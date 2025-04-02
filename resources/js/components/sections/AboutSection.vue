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
  <section id="about" class="about-section relative overflow-hidden py-12 md:py-16 lg:py-20">
    <!-- Background Effects -->
    <div class="absolute inset-0 noise-bg bg-gradient-to-br from-gray-50/80 to-white dark:from-gray-900/90 dark:to-gray-800/90"></div>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    
    <div class="container mx-auto px-6 md:px-8 lg:px-12 relative z-10 max-w-7xl">
      <h2 class="fade-in gradient-text text-4xl sm:text-5xl lg:text-6xl font-extrabold text-center mb-6">
        {{ content.title }}
      </h2>
      
      <p class="text-center !text-center mx-auto text-text-light dark:text-gray-400 text-lg max-w-3xl mb-16">
        {{ content.subtitle }}
      </p>
      
      <div class="flex-row-section h-full">
        <!-- Image Container -->
        <div class="fade-in perspective-container section-image-container rounded-lg overflow-hidden shadow-xl transform transition-all duration-500 hover:scale-[1.02] h-full">
          <div class="relative image-container h-full w-full overflow-hidden rounded-lg">
            <img :src="content.image" alt="About Us" class="relative z-10 section-image w-full h-full object-cover transition-transform duration-700 hover:scale-105">
            <div class="absolute -inset-2 glow-effect"></div>
            
            <!-- Frame corners -->
            <div class="frame-corner top-left"></div>
            <div class="frame-corner top-right"></div>
            <div class="frame-corner bottom-left"></div>
            <div class="frame-corner bottom-right"></div>
          </div>
        </div>
        
        <!-- Text Content -->
        <div class="fade-in space-y-6 flex flex-col">
          <p class="text-lg text-text-light dark:text-gray-400 mb-4">
            {{ content.paragraph1 }}
          </p>
          <p class="text-lg text-text-light dark:text-gray-400 mb-6">
            {{ content.paragraph2 }}
          </p>
          
          <div class="grid grid-cols-2 gap-6 mt-8">
            <div class="about-card p-6 rounded-lg shadow-sm text-center">
              <div class="text-primary-color text-3xl mb-3">
                <i :class="content.highlight1_icon"></i>
              </div>
              <h4 class="font-semibold text-text-color text-lg">{{ content.highlight1_title }}</h4>
            </div>
            <div class="about-card p-6 rounded-lg shadow-sm text-center">
              <div class="text-primary-color text-3xl mb-3">
                <i :class="content.highlight2_icon"></i>
              </div>
              <h4 class="font-semibold text-text-color text-lg">{{ content.highlight2_title }}</h4>
            </div>
            <div class="about-card p-6 rounded-lg shadow-sm text-center">
              <div class="text-primary-color text-3xl mb-3">
                <i :class="content.highlight3_icon"></i>
              </div>
              <h4 class="font-semibold text-text-color text-lg">{{ content.highlight3_title }}</h4>
            </div>
            <div class="about-card p-6 rounded-lg shadow-sm text-center">
              <div class="text-primary-color text-3xl mb-3">
                <i :class="content.highlight4_icon"></i>
              </div>
              <h4 class="font-semibold text-text-color text-lg">{{ content.highlight4_title }}</h4>
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

.image-container {
  height: 100%;
}

.image-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
}

.gradient-text {
  background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  width: 100%;
}

.frame-corner {
  position: absolute;
  width: 20px;
  height: 20px;
  border-width: 3px;
  border-color: var(--primary-color);
  z-index: 6;
}

.top-left {
  top: -5px;
  left: -5px;
  border-top-style: solid;
  border-left-style: solid;
  border-bottom-style: none;
  border-right-style: none;
  border-top-left-radius: 8px;
}

.top-right {
  top: -5px;
  right: -5px;
  border-top-style: solid;
  border-right-style: solid;
  border-bottom-style: none;
  border-left-style: none;
  border-top-right-radius: 8px;
}

.bottom-left {
  bottom: -5px;
  left: -5px;
  border-bottom-style: solid;
  border-left-style: solid;
  border-top-style: none;
  border-right-style: none;
  border-bottom-left-radius: 8px;
}

.bottom-right {
  bottom: -5px;
  right: -5px;
  border-bottom-style: solid;
  border-right-style: solid;
  border-top-style: none;
  border-left-style: none;
  border-bottom-right-radius: 8px;
}

.glow-effect {
  background: linear-gradient(
    135deg,
    rgba(var(--primary-rgb), 0.6),
    rgba(var(--secondary-rgb), 0.6)
  );
  border-radius: 24px;
  filter: blur(20px);
  opacity: 0.3;
  z-index: -1;
}

.perspective-container {
  perspective: 1000px;
  position: relative;
}

.section-image-container {
  height: 100%;
  min-height: 500px;
  display: flex;
}

@media (max-width: 1024px) {
  .section-image-container {
    min-height: 400px;
  }
}

.image-container {
  position: relative;
  transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
  transform-style: preserve-3d;
  border-radius: 16px;
  padding: 10px;
  flex: 1;
  display: flex;
}

.flex-row-section {
  display: grid;
  grid-template-columns: 1fr;
  align-items: stretch;
  gap: 2rem;
}

@media (min-width: 1024px) {
  .flex-row-section {
    grid-template-columns: 3fr 2fr;
    gap: 3rem;
  }
}
</style> 