<template>
  <div class="filters mb-4">
    <input v-model="search" @input="onFilterChange" placeholder="Search" class="border px-2 py-1" />
  </div>
</template>

<script setup>
import { ref, watchEffect } from 'vue'
import { useBookStore } from '../stores/bookStore'
import axios from 'axios'
axios.defaults.withCredentials = true

const store = useBookStore()
const search = ref(store.filters.search)
const author_id = ref(store.filters.author_id)
const authors = ref([])

const onFilterChange = () => {
  store.filters.search = search.value
  store.filters.author_id = author_id.value
  store.fetchBooks()
}

watchEffect(() => {
  axios.get('/api/author/index').then(res => authors.value = res.data)
})
</script>
