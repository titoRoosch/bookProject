<template>
  <div class="filters mb-4">
    <input v-model="search" @input="onFilterChange" placeholder="Search" class="border px-2 py-1" />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthorStore } from '../stores/authorStore'

const store = useAuthorStore()
const search = ref(store.filters.search)

const onFilterChange = () => {
  store.filters.search = search.value
  store.fetchAuthors()
}

</script>
