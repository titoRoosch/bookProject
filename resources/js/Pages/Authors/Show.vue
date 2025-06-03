<template>
  <div class="max-w-xl mx-auto space-y-4" v-if="author">
    <h1 class="text-2xl font-bold">Author: {{ author.name }}</h1>
    <p><strong>Date of Birth:</strong> {{ author.birth_date }}</p>
    <p>
      <strong>Books:</strong>
      <span v-for="book in author.books" :key="book.id" class="mr-2">
        {{ book.title }}
      </span>
    </p>


    <div class="flex gap-3 mt-6">
      <Link :href="`/authors/${author.id}/edit`" class="px-4 py-2 bg-yellow-500 text-white rounded">
        Edit
      </Link>

      <button
        @click="destroy"
        class="px-4 py-2 bg-red-600 text-white rounded"
      >
        Delete
      </button>
    </div>
  </div>
   <p v-else class="text-center text-gray-500 mt-10">Loading Author...</p>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { usePage, router, Link } from '@inertiajs/vue3'
axios.defaults.withCredentials = true

defineOptions({ layout: AuthenticatedLayout })

const page = usePage()
const author = ref(null)



onMounted(async () => {
  try {
    const url = page.url // e.g. "/authors/5"
    const id = url.split('/').pop()

    const response = await fetch(`/api/author/show/${id}`)
    author.value = await response.json()
    console.log(author);
  } catch (e) {
    console.error('Erro ao carregar livro:', e)
  }
})

async function destroy() {
  if (!confirm('Deseja mesmo excluir este livro?')) return

  try {
    await axios.delete(`/api/author/delete/${author.value.id}`)
    router.visit('/authors') // redireciona manualmente após sucesso
  } catch (e) {
    console.error('Erro ao excluir livro:', e)
  }
}
</script>
