<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

const isScrolled = ref(false);
const mobileMenuOpen = ref(false);

const bioInfo = ref({
  name: 'Danie de Villiers',
  phone: '078 393 2622',
  email: 'daniedevilliersbio@gmail.com',
  location: '4 Jonie street, Annlin, Pretoria'
});

const emit = defineEmits<{
  (e: 'open-booking'): void;
}>();

const toggleMobileMenu = () => {
  mobileMenuOpen.value = !mobileMenuOpen.value;
};

const handleScroll = () => {
  isScrolled.value = window.scrollY > 50;
};

const closeMenu = () => {
  mobileMenuOpen.value = false;
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
  handleScroll(); // Check initial scroll position
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
  <header :class="{ 'scrolled': isScrolled }">
    <div class="container mx-auto">
      <div class="navbar">
        <div class="logo">
          {{ bioInfo.name }}
        </div>
        
        <div class="flex items-center">
          <!-- Desktop Navigation -->
          <ul class="nav-links hidden md:flex">
            <li><a href="#home" class="nav-link">Home</a></li>
            <li><a href="#about" class="nav-link">About</a></li>
            <li><a href="#services" class="nav-link">Services</a></li>
            <li><a href="#testimonials" class="nav-link">Testimonials</a></li>
            <li><a href="#contact" class="nav-link">Contact</a></li>
            <li><a href="/admin/login" class="nav-link">Admin</a></li>
          </ul>
          
          <button @click="emit('open-booking')" class="btn btn-primary ml-4 hidden md:block">
            Book Appointment
          </button>
          
          <!-- Mobile Menu Toggle -->
          <button @click="toggleMobileMenu" class="md:hidden text-primary-color">
            <i :class="['fas', mobileMenuOpen ? 'fa-times' : 'fa-bars', 'text-2xl']"></i>
          </button>
        </div>
      </div>
    </div>
    
    <!-- Mobile Menu -->
    <div 
      class="mobile-menu md:hidden" 
      :class="{ 'active': mobileMenuOpen }"
      v-if="mobileMenuOpen"
    >
      <ul class="py-2 px-4">
        <li class="py-2"><a href="#home" @click="closeMenu" class="block">Home</a></li>
        <li class="py-2"><a href="#about" @click="closeMenu" class="block">About</a></li>
        <li class="py-2"><a href="#services" @click="closeMenu" class="block">Services</a></li>
        <li class="py-2"><a href="#testimonials" @click="closeMenu" class="block">Testimonials</a></li>
        <li class="py-2"><a href="#contact" @click="closeMenu" class="block">Contact</a></li>
        <li class="py-2"><a href="/admin/login" @click="closeMenu" class="block">Admin</a></li>
        <li class="pt-4">
          <button @click="emit('open-booking'); closeMenu();" class="btn btn-primary w-full">
            Book Appointment
          </button>
        </li>
      </ul>
    </div>
  </header>
</template>

<style scoped>
/* Most styling is now in app.css, just adding specific component styles */
.mobile-menu {
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  background-color: var(--bg-color);
  box-shadow: var(--card-shadow);
  border-bottom-left-radius: 0.5rem;
  border-bottom-right-radius: 0.5rem;
  z-index: 100;
  transform-origin: top;
  animation: slideDown 0.3s ease forwards;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.mobile-menu a {
  color: var(--text-color);
  font-weight: 500;
}

.mobile-menu a:hover {
  color: var(--primary-color);
}
</style> 