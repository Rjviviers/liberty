<script setup lang="ts">
import { ref } from 'vue';
import NavBar from '@/components/NavBar.vue';
import Footer from '@/components/Footer.vue';

const bookingModalOpen = ref(false);

const handleOpenBooking = () => {
  bookingModalOpen.value = true;
  // Emit this to the parent component
  emit('open-booking');
};

const emit = defineEmits(['open-booking']);
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <NavBar @open-booking="handleOpenBooking" />
    
    <main class="flex-grow">
      <slot></slot>
    </main>
    
    <Footer @open-booking="handleOpenBooking" />
  </div>
</template> 