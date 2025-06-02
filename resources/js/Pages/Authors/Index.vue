<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">List of Authors</h1>
    <div class="flex justify-between items-center mb-4">
      <AuthorFilters />

      <Link
        :href="`/authors/create`"
        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
      >
        Create new
      </Link>
    </div>

    <AuthorList />
    <Pagination
      v-if="pagination && pagination.total"
      :current-page="pagination.current_page"
      :total-pages="Math.ceil(pagination.total / pagination.per_page)"
      @change="handlePageChange"
    />

  </div>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
defineOptions({ layout: AuthenticatedLayout })

import { onMounted } from 'vue'
import { useAuthorStore } from '@/stores/authorStore'
import { storeToRefs } from 'pinia'
import AuthorFilters from '@/Components/AuthorFilters.vue'
import AuthorList from '@/Components/AuthorList.vue'
import Pagination from '@/Components/Pagination.vue'
import { Link } from '@inertiajs/vue3'

const store = useAuthorStore()
const { authors, pagination } = storeToRefs(store)

const handlePageChange = (page) => {
  store.fetchAuthors({ page }) // Envia o número da página como query param
}
onMounted(() => store.fetchAuthors())
</script>
