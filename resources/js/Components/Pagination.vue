<template>
  <nav class="mt-4 flex justify-center gap-1">
    <button
      :disabled="currentPage === 1"
      @click="$emit('change', currentPage - 1)"
      class="px-3 py-1 border rounded disabled:opacity-50"
    >
      ‹
    </button>

    <button
      v-for="page in pages"
      :key="page"
      @click="$emit('change', page)"
      :class="[
        'px-3 py-1 border rounded',
        page === currentPage ? 'bg-blue-500 text-white' : ''
      ]"
    >
      {{ page }}
    </button>

    <button
      :disabled="currentPage === totalPages"
      @click="$emit('change', currentPage + 1)"
      class="px-3 py-1 border rounded disabled:opacity-50"
    >
      ›
    </button>
  </nav>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  currentPage: { type: Number, required: true },
  totalPages: { type: Number, required: true },
})

const pages = computed(() => {
  const range = []
  for (let i = 1; i <= props.totalPages; i++) range.push(i)
  return range
})
</script>
