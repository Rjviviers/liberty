<script setup lang="ts">
import { ref } from 'vue';
import NavBar from '@/components/NavBar.vue';
import Footer from '@/components/Footer.vue';
import ThemeSelector from '@/components/ThemeSelector.vue';

const emit = defineEmits(['open-booking']);

const handleOpenBooking = () => {
  // Emit this to the parent component
  emit('open-booking');
};
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <NavBar @open-booking="handleOpenBooking" />
    
    <main class="flex-grow">
      <slot></slot>
    </main>
    
    <Footer @open-booking="handleOpenBooking" />
    <ThemeSelector />
  </div>
</template> 