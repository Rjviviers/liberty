<template>
  <div>
    <!-- Theme selector toggle button -->
    <div class="theme-selector-toggle" @click="toggleThemePanel">
      <i class="fas fa-palette"></i>
    </div>

    <!-- Theme selector panel -->
    <div class="theme-selector-panel" :class="{ active: themePanelOpen }">
      <h3>Theme Settings</h3>
      
      <!-- Light Themes -->
      <div class="theme-categories">
        <div class="theme-category-title">Light Themes</div>
        <div class="theme-options">
          <div 
            v-for="theme in lightThemes" 
            :key="theme.id" 
            class="theme-option" 
            :class="{ active: currentTheme === theme.id, [`theme-${theme.id}`]: true }"
            @click="setTheme(theme.id)"
          >
            <span>{{ theme.name }}</span>
            <div class="color-preview">
              <div class="color-dot primary"></div>
              <div class="color-dot secondary"></div>
              <div class="color-dot bg"></div>
              <div class="color-dot light"></div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Dark Themes -->
      <div class="theme-categories">
        <div class="theme-category-title">Dark Themes</div>
        <div class="theme-options">
          <div 
            v-for="theme in darkThemes" 
            :key="theme.id" 
            class="theme-option" 
            :class="{ active: currentTheme === theme.id, [`theme-${theme.id}`]: true }"
            @click="setTheme(theme.id)"
          >
            <span>{{ theme.name }}</span>
            <div class="color-preview">
              <div class="color-dot primary"></div>
              <div class="color-dot secondary"></div>
              <div class="color-dot bg"></div>
              <div class="color-dot light"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      themePanelOpen: false,
      currentTheme: 'classic',
      lightThemes: [
        { id: 'classic', name: 'Classic Blue' },
        { id: 'ocean', name: 'Ocean Blue' },
        { id: 'forest', name: 'Forest Green' },
        { id: 'midnight', name: 'Midnight Purple' },
        { id: 'gothic', name: 'Gothic Pink' },
        { id: 'earthdark', name: 'Earth Tones' },
      ],
      darkThemes: [
        { id: 'dark-blue', name: 'Dark Blue' },
        { id: 'dark-emerald', name: 'Dark Emerald' },
        { id: 'dark-violet', name: 'Dark Violet' },
      ]
    };
  },
  
  mounted() {
    // Check local storage for saved theme
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
      this.setTheme(savedTheme);
    }
  },
  
  methods: {
    toggleThemePanel() {
      this.themePanelOpen = !this.themePanelOpen;
    },
    
    setTheme(themeId) {
      // Remove all theme classes
      const allThemes = [...this.lightThemes, ...this.darkThemes].map(theme => `theme-${theme.id}`);
      document.body.classList.remove(...allThemes);
      
      // Add the selected theme class
      document.body.classList.add(`theme-${themeId}`);
      
      // Save to localStorage
      localStorage.setItem('theme', themeId);
      
      // Update current theme
      this.currentTheme = themeId;
      
      // Close panel on mobile
      if (window.innerWidth < 768) {
        this.themePanelOpen = false;
      }
    }
  }
};
</script> 