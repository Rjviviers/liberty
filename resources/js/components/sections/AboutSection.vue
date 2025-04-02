<script setup lang="ts">
// No props or emits needed for this component
</script>

<template>
  <section id="about" class="py-16 bg-bg-light">
    <div class="container mx-auto px-4">
      <h2 class="section-title">About Danie de Villiers</h2>
      
      <div class="grid md:grid-cols-2 gap-8 items-center">
        <div class="animate-slide-right">
          <h3 class="text-2xl font-semibold mb-4">Dedicated to Your Well-being</h3>
          <p class="mb-4">As a professional biokineticist, Danie de Villiers believes that everyone deserves personalized care that respects their unique needs and circumstances. For over 15 years, he's been providing exceptional biokinetic services to the community.</p>
          <p class="mb-4">With extensive experience in exercise therapy, Danie is committed to offering comprehensive care that addresses both immediate concerns and long-term health goals. He combines medical expertise with a compassionate approach to ensure that every patient feels heard, supported, and empowered.</p>
          
          <div class="grid grid-cols-2 gap-4 mt-6">
            <div class="bg-white p-4 rounded-lg shadow-sm text-center">
              <div class="text-primary-color text-3xl mb-2">
                <i class="fas fa-user-md"></i>
              </div>
              <h4 class="font-semibold">Expert Care</h4>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm text-center">
              <div class="text-primary-color text-3xl mb-2">
                <i class="fas fa-heartbeat"></i>
              </div>
              <h4 class="font-semibold">Personalized Treatment</h4>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm text-center">
              <div class="text-primary-color text-3xl mb-2">
                <i class="fas fa-clinic-medical"></i>
              </div>
              <h4 class="font-semibold">Modern Techniques</h4>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm text-center">
              <div class="text-primary-color text-3xl mb-2">
                <i class="fas fa-users"></i>
              </div>
              <h4 class="font-semibold">Patient Community</h4>
            </div>
          </div>
        </div>
        
        <div class="animate-slide-left">
          <div class="relative">
            <div class="bg-primary-color w-full h-64 md:h-80 rounded-lg overflow-hidden shadow-lg">
              <!-- Use Unsplash image -->
              <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="About Danie de Villiers" class="w-full h-full object-cover">
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-xs mx-auto md:mx-0 md:absolute md:-bottom-10 md:-left-10">
              <div class="flex items-center space-x-4">
                <div class="text-secondary-color text-4xl">
                  <i class="fas fa-award"></i>
                </div>
                <div>
                  <h4 class="font-bold text-lg">15+ Years</h4>
                  <p class="text-sm text-gray-600">of excellence in biokinetics</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template> 