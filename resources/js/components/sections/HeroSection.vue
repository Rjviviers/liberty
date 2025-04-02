<script setup lang="ts">
import { onMounted, ref } from 'vue';

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

const mousePosition = ref({ x: 0, y: 0 });

const updateMousePosition = (e: MouseEvent) => {
  mousePosition.value = {
    x: (e.clientX / window.innerWidth) - 0.5,
    y: (e.clientY / window.innerHeight) - 0.5
  };
};

onMounted(() => {
  document.addEventListener('mousemove', updateMousePosition);
  
  // Animate elements with staggered timing
  const heroElements = document.querySelectorAll('.fade-in');
  heroElements.forEach((el, index) => {
    setTimeout(() => {
      el.classList.add('visible');
    }, 300 + (index * 200));
  });

  return () => {
    document.removeEventListener('mousemove', updateMousePosition);
  };
});
</script>

<template>
  <section 
    id="home" 
    class="hero-container relative overflow-hidden"
  >
    <!-- Animated Background -->
    <div class="absolute inset-0 noise-bg bg-gradient-to-br from-gray-50/80 to-white dark:from-gray-900/90 dark:to-gray-800/90"></div>
    
    <!-- Animated blobs -->
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
    
    <!-- Grid Pattern -->
    <div class="absolute inset-0 z-0 grid-pattern opacity-10 dark:opacity-5"></div>
    
    <!-- Main Content -->
    <div class="container relative z-10 mx-auto px-4 h-full flex items-center">
      <div class="flex flex-col lg:flex-row items-center justify-between w-full gap-16">
        <!-- Text Content -->
        <div class="lg:w-1/2 space-y-8 text-center lg:text-left">
          <div class="space-y-3">
            <p class="fade-in glitch-text uppercase tracking-widest text-sm font-semibold text-secondary-color">
              Professional Biokineticist
            </p>
            
            <h1 class="fade-in hero-title text-5xl sm:text-6xl lg:text-7xl font-extrabold leading-tight">
              <span class="block">{{ content.heading.split(' ')[0] }}</span>
              <span class="gradient-text">{{ content.heading.split(' ').slice(1).join(' ') }}</span>
            </h1>
            
            <p class="fade-in text-xl font-medium text-gray-700 dark:text-gray-300 mt-4">
              {{ content.subheading }}
            </p>
          </div>
          
          <p class="fade-in text-base sm:text-lg text-gray-600 dark:text-gray-400 max-w-xl mx-auto lg:mx-0">
            {{ content.description }}
          </p>
          
          <div class="fade-in flex flex-col sm:flex-row gap-5 pt-6">
            <button 
              @click="emit('open-booking')" 
              class="button primary"
            >
              <span>{{ content.button_text }}</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </button>
            
            <a 
              href="/admin/login" 
              class="button secondary"
            >
              <span>{{ content.admin_button_text }}</span>
            </a>
          </div>
          
          <!-- Decorative Elements -->
          <div class="hidden lg:block absolute -left-10 bottom-20 w-16 h-16 rotating-square"></div>
        </div>
        
        <!-- Image Container -->
        <div class="fade-in lg:w-1/2 perspective-container">
          <div 
            class="relative image-container"
            :style="{
              transform: `rotateY(${mousePosition.x * 5}deg) rotateX(${-mousePosition.y * 5}deg)`
            }"
          >
            <!-- Main image with special effects -->
            <img 
              :src="content.image" 
              alt="Danie De Villiers - Professional Biokineticist" 
              class="relative z-10 main-image"
            >
            
            <!-- Layered glowing effects -->
            <div class="absolute -inset-2 glow-effect"></div>
            <div class="absolute -inset-1 blur-sm bg-gradient-to-tr from-primary-color/30 to-secondary-color/30 rounded-2xl z-0"></div>
            
            <!-- Floating elements -->
            <div class="floating-circle circle-1"></div>
            <div class="floating-circle circle-2"></div>
            <div class="floating-circle circle-3"></div>
            <div class="floating-line line-1"></div>
            <div class="floating-line line-2"></div>
          </div>
          
          <!-- Digital frame elements -->
          <div class="frame-corner top-left"></div>
          <div class="frame-corner top-right"></div>
          <div class="frame-corner bottom-left"></div>
          <div class="frame-corner bottom-right"></div>
        </div>
      </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 scroll-indicator">
      <div class="scroll-arrow"></div>
    </div>
  </section>
</template>

<style scoped>
.hero-container {
  min-height: calc(100vh - 80px);
  width: 100%;
  position: relative;
}

/* === Text styling === */
.hero-title {
  overflow: hidden;
  line-height: 1.1;
}

.gradient-text {
  background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  display: inline-block;
  position: relative;
}

.gradient-text::after {
  content: '';
  position: absolute;
  width: 100%;
  transform: scaleX(0);
  height: 3px;
  bottom: 0;
  left: 0;
  background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
  transform-origin: bottom right;
  transition: transform 0.5s cubic-bezier(0.645, 0.045, 0.355, 1);
}

.hero-title:hover .gradient-text::after {
  transform: scaleX(1);
  transform-origin: bottom left;
}

.glitch-text {
  position: relative;
  animation: glitch 5s infinite;
}

@keyframes glitch {
  0%, 93%, 100% { transform: translate(0); }
  93.5% { transform: translate(2px, 2px); }
  94% { transform: translate(-2px, -2px); }
  94.5% { transform: translate(2px, -2px); }
  95% { transform: translate(-2px, 2px); }
  95.5% { transform: translate(0); }
}

/* === Background elements === */
.noise-bg {
  position: absolute;
  inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
  opacity: 0.08;
  mix-blend-mode: overlay;
}

.grid-pattern {
  background-image: linear-gradient(to right, rgba(108, 126, 254, 0.1) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(108, 126, 254, 0.1) 1px, transparent 1px);
  background-size: 40px 40px;
}

.blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(60px);
}

.blob-1 {
  width: 500px;
  height: 500px;
  background: radial-gradient(circle, rgba(var(--primary-rgb), 0.2), rgba(var(--primary-rgb), 0));
  top: 10%;
  right: -200px;
  animation: blob-move-1 20s infinite alternate ease-in-out;
}

.blob-2 {
  width: 400px;
  height: 400px;
  background: radial-gradient(circle, rgba(var(--secondary-rgb), 0.15), rgba(var(--secondary-rgb), 0));
  bottom: 10%;
  left: -150px;
  animation: blob-move-2 25s infinite alternate-reverse ease-in-out;
}

.blob-3 {
  width: 300px;
  height: 300px;
  background: radial-gradient(circle, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
  top: 30%;
  left: 30%;
  animation: blob-move-3 30s infinite alternate ease-in-out;
}

@keyframes blob-move-1 {
  0% { transform: translate(0, 0) scale(1); }
  100% { transform: translate(50px, 100px) scale(1.2); }
}

@keyframes blob-move-2 {
  0% { transform: translate(0, 0) scale(1); }
  100% { transform: translate(80px, -40px) scale(1.3); }
}

@keyframes blob-move-3 {
  0% { transform: translate(0, 0) scale(1); }
  100% { transform: translate(-60px, 80px) scale(1.1); }
}

/* === Image and 3D effects === */
.perspective-container {
  perspective: 1000px;
  position: relative;
}

.image-container {
  position: relative;
  transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
  transform-style: preserve-3d;
  border-radius: 16px;
  padding: 10px;
}

.main-image {
  width: 100%;
  height: auto;
  object-fit: contain;
  transform: translateZ(20px);
  filter: drop-shadow(0 20px 30px rgba(0, 0, 0, 0.1));
  transition: all 0.3s ease;
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
  transform: translateZ(-20px);
}

.floating-circle {
  position: absolute;
  border-radius: 50%;
  border: 2px solid;
  z-index: 5;
}

.circle-1 {
  width: 30px;
  height: 30px;
  top: 20%;
  left: -15px;
  border-color: var(--primary-color);
  animation: float-circle 6s infinite ease-in-out;
}

.circle-2 {
  width: 20px;
  height: 20px;
  bottom: 15%;
  right: -10px;
  border-color: var(--secondary-color);
  animation: float-circle 8s infinite ease-in-out reverse;
}

.circle-3 {
  width: 40px;
  height: 40px;
  top: -20px;
  right: 20%;
  border-color: rgba(255, 255, 255, 0.5);
  border-style: dashed;
  animation: float-circle 10s infinite ease-in-out;
}

.floating-line {
  position: absolute;
  background: linear-gradient(90deg, transparent, currentColor, transparent);
  height: 2px;
  z-index: 5;
}

.line-1 {
  width: 60px;
  top: 30%;
  right: -30px;
  transform: rotate(60deg);
  color: var(--primary-color);
  animation: pulse 3s infinite;
}

.line-2 {
  width: 40px;
  bottom: 40px;
  left: 10%;
  color: var(--secondary-color);
  animation: pulse 4s infinite reverse;
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

.rotating-square {
  border: 2px solid var(--primary-color);
  animation: rotate 10s linear infinite;
}

@keyframes float-circle {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-15px); }
}

@keyframes pulse {
  0%, 100% { opacity: 0.3; }
  50% { opacity: 0.8; }
}

@keyframes rotate {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* === Buttons === */
.button {
  position: relative;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 14px 28px;
  border-radius: 8px;
  font-weight: 600;
  font-size: 16px;
  transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
  overflow: hidden;
  z-index: 1;
}

.button::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 0;
  height: 100%;
  transition: width 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  z-index: -1;
}

.button:hover::before {
  width: 100%;
}

.button.primary {
  background: var(--primary-color);
  color: white;
  box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.3);
}

.button.primary:hover {
  box-shadow: 0 6px 20px rgba(var(--primary-rgb), 0.4);
  transform: translateY(-2px);
}

.button.primary::before {
  background: var(--secondary-color);
}

.button.secondary {
  background: transparent;
  color: var(--primary-color);
  border: 2px solid var(--primary-color);
}

.button.secondary:hover {
  color: white;
  transform: translateY(-2px);
}

.button.secondary::before {
  background: var(--primary-color);
}

/* === Scroll Indicator === */
.scroll-indicator {
  display: flex;
  flex-direction: column;
  align-items: center;
  opacity: 0.7;
}

.scroll-arrow {
  width: 28px;
  height: 48px;
  border: 2px solid var(--primary-color);
  border-radius: 14px;
  position: relative;
}

.scroll-arrow::before {
  content: '';
  position: absolute;
  top: 6px;
  left: 50%;
  width: 6px;
  height: 6px;
  margin-left: -3px;
  background-color: var(--primary-color);
  border-radius: 50%;
  animation: scroll 2s infinite;
}

@keyframes scroll {
  0% { transform: translateY(0); opacity: 1; }
  50% { transform: translateY(15px); opacity: 0.3; }
  100% { transform: translateY(0); opacity: 1; }
}

/* === Fade-in animations === */
.fade-in {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.fade-in.visible {
  opacity: 1;
  transform: translateY(0);
}

/* === Dark mode adjustments === */
:root[data-theme="dark"] .button.secondary {
  color: white;
  border-color: white;
}

:root[data-theme="dark"] .button.secondary::before {
  background: var(--primary-color);
}

:root[data-theme="dark"] .frame-corner {
  border-color: var(--secondary-color);
}

:root[data-theme="dark"] .scroll-arrow {
  border-color: var(--secondary-color);
}

:root[data-theme="dark"] .scroll-arrow::before {
  background-color: var(--secondary-color);
}
</style> 