<script setup lang="ts">
import { ref, onMounted, onUnmounted, watch } from 'vue';

const isScrolled = ref(false);
const mobileMenuOpen = ref(false);
const activeSection = ref('home');
const isMobile = ref(false);

const bioInfo = ref({
  name: 'Danie de Villiers',
  phone: '078 393 2622',
  email: 'daniedevilliersbio@gmail.com',
  location: '4 Jonie street, Annlin, Pretoria'
});

const navItems = ref([
  { text: 'Home', link: '#home', id: 'home', icon: 'fas fa-home' },
  { text: 'About', link: '#about', id: 'about', icon: 'fas fa-info-circle' },
  { text: 'Services', link: '#services', id: 'services', icon: 'fas fa-hand-holding-medical' },
  { text: 'Testimonials', link: '#testimonials', id: 'testimonials', icon: 'fas fa-quote-left' },
  { text: 'Contact', link: '#contact', id: 'contact', icon: 'fas fa-envelope' }
]);

const emit = defineEmits<{
  (e: 'open-booking'): void;
}>();

const toggleMobileMenu = () => {
  mobileMenuOpen.value = !mobileMenuOpen.value;
};

const handleScroll = () => {
  isScrolled.value = window.scrollY > 50;
  
  // Check which section is currently in view for highlighting
  const sections = document.querySelectorAll('section[id]');
  let scrollPosition = window.scrollY + 100; // Add offset for header height
  
  sections.forEach(section => {
    const sectionTop = (section as HTMLElement).offsetTop;
    const sectionHeight = (section as HTMLElement).offsetHeight;
    const sectionId = section.getAttribute('id') || '';
    
    if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
      activeSection.value = sectionId;
    }
  });
};

const closeMenu = () => {
  mobileMenuOpen.value = false;
};

const checkScreenSize = () => {
  isMobile.value = window.innerWidth < 768;
  if (!isMobile.value) {
    closeMenu();
  }
};

// Smooth scroll to section
const scrollToSection = (sectionId: string, event?: Event) => {
  if (event) event.preventDefault();
  
  const section = document.getElementById(sectionId);
  if (section) {
    section.scrollIntoView({ behavior: 'smooth' });
    activeSection.value = sectionId;
  }
  
  closeMenu();
};

// Close mobile menu when clicking outside
const handleClickOutside = (event: MouseEvent) => {
  const target = event.target as HTMLElement;
  const mobileMenu = document.querySelector('.mobile-menu');
  const menuToggle = document.querySelector('.hamburger-button');
  
  if (mobileMenuOpen.value && 
      mobileMenu && 
      !mobileMenu.contains(target) && 
      menuToggle && 
      !menuToggle.contains(target)) {
    closeMenu();
  }
};

// Watch for mobile menu open/close to manage body scroll
watch(mobileMenuOpen, (isOpen) => {
  if (isOpen) {
    document.body.style.overflow = 'hidden'; // Prevent scrolling when menu is open
    document.body.classList.add('mobile-menu-open'); // Add class for overlay styling
  } else {
    document.body.style.overflow = ''; // Restore scrolling
    document.body.classList.remove('mobile-menu-open'); // Remove class
  }
});

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
  window.addEventListener('resize', checkScreenSize);
  document.addEventListener('click', handleClickOutside);
  checkScreenSize(); // Check initial screen size
  handleScroll(); // Check initial scroll position
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
  window.removeEventListener('resize', checkScreenSize);
  document.removeEventListener('click', handleClickOutside);
  document.body.style.overflow = ''; // Restore scrolling on unmount
});
</script>

<template>
  <header class="navbar-container" :class="{ 'scrolled': isScrolled }">
    <div class="container mx-auto">
      <nav class="navbar">
        <a href="#" class="navbar-brand">
          <div class="logo-text">
            <span class="logo-main">{{ bioInfo.name }}</span>
            <span class="logo-subtitle">BIOKINETICIST</span>
          </div>
        </a>

        <!-- Desktop Navigation Menu -->
        <ul class="navbar-nav flex items-center" v-show="!isMobile">
          <li v-for="item in navItems" :key="item.text" class="flex items-center">
            <a 
              :href="item.link" 
              class="nav-link" 
              :class="{ 'active': activeSection === item.id }" 
              @click.prevent="scrollToSection(item.id, $event)"
            >
              {{ item.text }}
            </a>
          </li>
          <li class="flex items-center"><a href="/admin/login" class="nav-link">Admin</a></li>
          <li class="flex items-center">
            <button @click="emit('open-booking')" class="btn btn-primary ml-4">
              Book Appointment
            </button>
          </li>
        </ul>

        <!-- Mobile Menu Button -->
        <button 
          class="hamburger-button" 
          v-show="isMobile" 
          @click="toggleMobileMenu"
          aria-label="Toggle mobile menu"
          :aria-expanded="mobileMenuOpen ? 'true' : 'false'"
        >
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
          <span class="hamburger-line"></span>
        </button>
      </nav>
    </div>

    <!-- Mobile Menu Backdrop -->
    <div 
      class="mobile-menu-backdrop" 
      v-show="mobileMenuOpen" 
      @click="closeMenu"
    ></div>
        
    <!-- Mobile Menu -->
    <transition name="slide">
      <div class="mobile-menu" v-show="mobileMenuOpen">
        <div class="mobile-menu-header">
          <div class="logo-text">
            <span class="logo-main">{{ bioInfo.name }}</span>
            <span class="logo-subtitle">BIOKINETICIST</span>
          </div>
          <button 
            class="mobile-menu-close" 
            @click="closeMenu"
            aria-label="Close mobile menu"
          >
            <i class="fas fa-times"></i>
          </button>
        </div>
        
        <div class="mobile-menu-container">
          <ul>
            <li v-for="item in navItems" :key="item.text">
              <a 
                :href="item.link" 
                :class="{ 'active': activeSection === item.id }"
                @click.prevent="scrollToSection(item.id, $event)"
              >
                <i :class="['mobile-menu-icon', item.icon]"></i>
                {{ item.text }}
              </a>
            </li>
            <li>
              <a href="/admin/login" @click="closeMenu" class="flex items-center">
                <i class="mobile-menu-icon fas fa-lock"></i>
                Admin
              </a>
            </li>
            <li class="pt-4">
              <button @click="emit('open-booking'); closeMenu();" class="btn btn-primary w-full flex items-center justify-center">
                <i class="fas fa-calendar-plus mr-2"></i>
                <span>Book Appointment</span>
              </button>
            </li>
          </ul>
          
          <div class="mobile-contact-section">
            <h4 class="text-lg font-bold mb-3">Quick Contact</h4>
            <div class="mobile-contact-item">
              <i class="fas fa-phone-alt"></i>
              <a href="tel:+27{{ bioInfo.phone.replace(/\s/g, '') }}">{{ bioInfo.phone }}</a>
            </div>
            <div class="mobile-contact-item">
              <i class="fas fa-envelope"></i>
              <a href="mailto:{{ bioInfo.email }}">{{ bioInfo.email }}</a>
            </div>
            <div class="mobile-contact-item">
              <i class="fas fa-map-marker-alt"></i>
              <span>{{ bioInfo.location }}</span>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </header>
</template>

<style scoped>
/* Most styling is now in app.css, just adding specific component styles */
.logo-text {
  font-weight: 700;
  font-size: 1.5rem;
  color: var(--primary-color);
  transition: var(--transition-normal);
}

.logo-subtitle {
  color: var(--text-light);
  font-weight: 400;
  font-size: 1rem;
}

.nav-link.active {
  color: var(--primary-color);
  font-weight: 600;
}

.nav-link.active::after {
  width: 100%;
}

/* Mobile menu transitions */
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
  transform: translateX(-100%);
}

.mobile-menu-header {
  background-color: var(--bg-light);
}

@media (max-width: 767px) {
  .mobile-menu a {
    color: var(--text-color);
    font-weight: 500;
    display: flex;
    align-items: center;
    padding: 0.75rem 0.5rem;
    border-bottom: 1px solid var(--border-color);
  }
  
  .mobile-menu a:hover, .mobile-menu a.active {
    color: var(--primary-color);
    background-color: var(--bg-light);
    border-left: 3px solid var(--primary-color);
    padding-left: calc(0.5rem - 3px);
  }
  
  .mobile-menu li:last-child a {
    border-bottom: none;
  }
}
</style> 