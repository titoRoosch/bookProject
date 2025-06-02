<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">List of Books</h1>
    <div class="flex justify-between items-center mb-4">
      <BookFilters />

      <Link
        :href="`/books/create`"
        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
      >
        Create new
      </Link>
    </div>
    <BookList />

    <Pagination
      v-if="pagination && pagination.total"
      :current-page="pagination.current_page"
      :total-pages="Math.ceil(pagination.total / (pagination.per_page || 1))"
      @change="handlePageChange"
    />
  </div>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
defineOptions({ layout: AuthenticatedLayout })

import { onMounted } from 'vue'
import { useBookStore } from '@/stores/bookStore'
import { storeToRefs } from 'pinia'
import BookFilters from '@/Components/BookFilters.vue'
import BookList from '@/Components/BookList.vue'
import Pagination from '@/Components/Pagination.vue'
import { Link } from '@inertiajs/vue3'

const store = useBookStore()
const { books, pagination } = storeToRefs(store)

const handlePageChange = (page) => {
  store.fetchBooks({ page })
}

onMounted(async () => {
  try {
    await store.fetchBooks()
  } catch (error) {
    console.error('Erro ao carregar livros:', error)
  }
})
</script>
