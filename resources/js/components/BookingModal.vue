<script setup lang="ts">
import { ref } from 'vue';

const props = defineProps<{
  isOpen: boolean;
}>();

const emit = defineEmits<{
  (e: 'close'): void;
}>();

const bookingLoading = ref(false);
const bookingForm = ref({
  name: '',
  email: '',
  phone: '',
  date: '',
  time: '',
  service: '',
  message: ''
});

const services = ref([
  {
    id: 1,
    title: 'Injury Rehabilitation',
  },
  {
    id: 2,
    title: 'Chronic Disease Management',
  },
  {
    id: 3,
    title: 'Sports Performance Optimization',
  },
  {
    id: 4,
    title: 'Orthopaedic Rehabilitation',
  },
  {
    id: 5,
    title: 'Posture Analysis and Correction',
  },
  {
    id: 6,
    title: 'Elderly Fitness and Fall Prevention',
  }
]);

const submitBookingForm = async () => {
  // Basic form validation
  const requiredFields = ['name', 'email', 'phone', 'date', 'time', 'service'];
  for (const field of requiredFields) {
    if (!bookingForm.value[field]) {
      alert('Please fill in all required fields');
      return;
    }
  }
  
  bookingLoading.value = true;
  
  try {
    // This connects to Laravel backend
    const response = await fetch('/api/book-appointment', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      },
      body: JSON.stringify(bookingForm.value)
    });
    
    const data = await response.json();
    
    if (data.success) {
      alert('Your appointment has been booked successfully! We will contact you shortly to confirm.');
      resetBookingForm();
      emit('close');
    } else {
      alert('There was an error booking your appointment. Please try again or contact us directly.');
    }
  } catch (error) {
    console.error('Error submitting booking form:', error);
    alert('There was an error booking your appointment. Please try again or contact us directly.');
  } finally {
    bookingLoading.value = false;
  }
};

const resetBookingForm = () => {
  bookingForm.value = {
    name: '',
    email: '',
    phone: '',
    date: '',
    time: '',
    service: '',
    message: ''
  };
};
</script>

<template>
  <div class="modal-overlay" :class="{'active': isOpen}">
    <div class="modal" @click.stop>
      <div class="modal-header">
        <h3>Book an Appointment</h3>
        <div class="modal-close" @click="$emit('close')">
          <i class="fas fa-times"></i>
        </div>
      </div>
      <div class="modal-body">
        <form class="booking-form" @submit.prevent="submitBookingForm">
          <div class="form-row">
            <div class="form-group">
              <label for="booking-name">Full Name</label>
              <input type="text" id="booking-name" v-model="bookingForm.name" required placeholder="Your name">
            </div>
            <div class="form-group">
              <label for="booking-phone">Phone Number</label>
              <input type="tel" id="booking-phone" v-model="bookingForm.phone" required placeholder="Your phone number">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="booking-email">Email Address</label>
              <input type="email" id="booking-email" v-model="bookingForm.email" required placeholder="Your email">
            </div>
            <div class="form-group">
              <label for="booking-date">Preferred Date</label>
              <input type="date" id="booking-date" v-model="bookingForm.date" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="booking-time">Preferred Time</label>
              <select id="booking-time" v-model="bookingForm.time" required>
                <option value="" disabled selected>Select a time</option>
                <option value="morning">Morning (8:00 - 12:00)</option>
                <option value="afternoon">Afternoon (13:00 - 17:00)</option>
              </select>
            </div>
            <div class="form-group">
              <label for="booking-service">Service Required</label>
              <select id="booking-service" v-model="bookingForm.service" required>
                <option value="" disabled selected>Select a service</option>
                <option v-for="service in services" :key="service.id" :value="service.title">
                  {{ service.title }}
                </option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="booking-message">Additional Information</label>
            <textarea 
              id="booking-message" 
              v-model="bookingForm.message" 
              placeholder="Please provide any additional information about your condition or requirements"
            ></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="modal-btn secondary" @click="$emit('close')">Cancel</button>
        <button class="modal-btn primary" @click="submitBookingForm" :disabled="bookingLoading">
          {{ bookingLoading ? 'Processing...' : 'Book Appointment' }}
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 2000;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
}

.modal-overlay.active {
  opacity: 1;
  visibility: visible;
}

.modal {
  background-color: white;
  border-radius: 8px;
  width: 90%;
  max-width: 700px;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  display: flex;
  flex-direction: column;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.5rem;
  border-bottom: 1px solid #eee;
}

.modal-header h3 {
  margin: 0;
  color: var(--primary-color);
}

.modal-close {
  cursor: pointer;
  font-size: 1.5rem;
  color: #777;
  transition: all 0.2s ease;
}

.modal-close:hover {
  color: var(--primary-color);
}

.modal-body {
  padding: 1.5rem;
  flex-grow: 1;
}

.modal-footer {
  padding: 1rem 1.5rem;
  border-top: 1px solid #eee;
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
}

.booking-form .form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
  margin-bottom: 1rem;
}

.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-family: inherit;
  font-size: 1rem;
}

.form-group textarea {
  min-height: 100px;
  resize: vertical;
}

.modal-btn {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 4px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
}

.modal-btn.primary {
  background-color: var(--primary-color);
  color: white;
}

.modal-btn.primary:hover {
  background-color: var(--primary-dark);
}

.modal-btn.secondary {
  background-color: #f0f0f0;
  color: #333;
}

.modal-btn.secondary:hover {
  background-color: #e0e0e0;
}

.modal-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

@media (max-width: 768px) {
  .booking-form .form-row {
    grid-template-columns: 1fr;
  }
}
</style> 