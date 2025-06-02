
<template>
  <div class="min-h-screen bg-gray-50 relative">
    <Sidebar :open="sidebarOpen" @close="sidebarOpen = false" />

    <header class="p-4 bg-white border-b shadow-sm flex items-center">
      <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 hover:text-black">

        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
      <h1 class="ml-4 text-lg font-bold">Book System</h1>
    </header>

    <main class="p-6">
      <router-view />
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Sidebar from './Sidebar.vue'

const sidebarOpen = ref(false)
</script>
