<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">List of Authors</h1>
    <BookFilters />
    <AuthorList />
    <Pagination
      :current-page="pagination.current_page"
      :total-pages="Math.ceil(pagination.total / pagination.per_page)"
      @change="handlePageChange"
    />

  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useAuthorStore } from '../stores/authorStore'
import { storeToRefs } from 'pinia'
import BookFilters from '../components/BookFilters.vue'
import AuthorList from '../components/AuthorList.vue'
import Pagination from '../components/Pagination.vue'

const store = useAuthorStore()
const { authors, pagination } = storeToRefs(store)

console.log(pagination);

const handlePageChange = (page) => {
  store.fetchAuthors({ page }) // Envia o número da página como query param
}
onMounted(() => store.fetchAuthors())
</script>
