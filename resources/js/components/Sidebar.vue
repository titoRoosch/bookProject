<template>
  <transition name="slide">
    <aside
      v-if="open"
      class="fixed inset-0 z-40 flex"
    >
      <!-- Backdrop -->
      <div class="bg-black bg-opacity-50 w-full" @click="$emit('close')"></div>

      <!-- Sidebar -->
      <div class="w-64 bg-white shadow-lg p-4 z-50">
        <h2 class="text-xl font-semibold mb-6">Menu</h2>
        <nav class="flex flex-col gap-2">
          <RouterLink
            to="/books"
            class="text-gray-700 hover:text-blue-600"
            @click="$emit('close')"
          >
            Books
          </RouterLink>

          <RouterLink
            to="/authors"
            class="text-gray-700 hover:text-blue-600"
            @click="$emit('close')"
          >
            Authors
          </RouterLink>
          <RouterLink 
            to="/dashboard" 
            class="text-gray-700 hover:text-blue-600"
            @click="$emit('close')"
            >
            Dashboard
        </RouterLink>
        </nav>
      </div>
    </aside>
  </transition>
</template>

<script setup>
import { RouterLink } from 'vue-router'
defineProps({ open: Boolean })
defineEmits(['close'])
</script>

<style scoped>
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease;
}
.slide-enter-from {
  transform: translateX(-100%);
}
.slide-leave-to {
  transform: translateX(-100%);
}
</style>
