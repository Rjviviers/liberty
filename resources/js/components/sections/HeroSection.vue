<script setup lang="ts">
const emit = defineEmits<{
  (e: 'open-booking'): void;
}>();
</script>

<template>
  <section id="home" class="hero">
    <div class="container mx-auto">
      <div class="hero-container grid md:grid-cols-2 gap-8 items-center">
        <div class="hero-content animate-slide-right">
          <h1 class="text-4xl md:text-5xl font-bold mb-4 text-primary-color">Specialized Exercise Therapy</h1>
          <h2 class="text-2xl font-medium mb-6 text-secondary-color">Restore Movement. Regain Life.</h2>
          <p class="mb-8 text-gray-700">Professional biokinetics services for rehabilitation, chronic disease management, and sports performance optimization. Let me help you achieve optimal physical function and improve your quality of life through evidence-based exercise therapy.</p>
          <div class="flex flex-wrap gap-4">
            <button @click="$emit('open-booking')" class="btn btn-primary">
              Book a Consultation
            </button>
            <a href="#services" class="btn btn-outline">
              Our Services
            </a>
          </div>
        </div>
        <div class="hero-image animate-slide-left">
          <img src="https://liberty.test/assets/Danie%20De%20Villiers.png" alt="Danie de Villiers - Professional Biokineticist">
        </div>
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