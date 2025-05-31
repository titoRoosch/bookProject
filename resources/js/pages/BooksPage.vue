<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Lista de Livros</h1>
    <BookFilters />
    <BookList />
    <Pagination
      :current-page="pagination.current_page"
      :total-pages="Math.ceil(pagination.total / pagination.per_page)"
      @change="handlePageChange"
    />

  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useBookStore } from '../stores/bookStore'
import { storeToRefs } from 'pinia'
import BookFilters from '../components/BookFilters.vue'
import BookList from '../components/BookList.vue'
import Pagination from '../components/Pagination.vue'

const store = useBookStore()
const { books, pagination } = storeToRefs(store)

console.log(pagination);

const handlePageChange = (page) => {
  store.fetchBooks({ page }) // Envia o número da página como query param
}
onMounted(() => store.fetchBooks())
</script>
