<template>
  <div class="max-w-xl mx-auto space-y-4" v-if="book">
    <h1 class="text-2xl font-bold">Book: {{ book.title }}</h1>
    <p><strong>Published at:</strong> {{ book.publish_date }}</p>
    <p>
      <strong>Authors:</strong>
      <span v-for="author in book.authors" :key="author.id" class="mr-2">
        {{ author.name }}
      </span>
    </p>

    <div class="flex gap-3 mt-6">
      <Link :href="`/books/${book.id}/edit`" class="px-4 py-2 bg-yellow-500 text-white rounded">
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

  <p v-else class="text-center text-gray-500 mt-10">Carregando livro...</p>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { usePage, router, Link } from '@inertiajs/vue3'

defineOptions({ layout: AuthenticatedLayout })

const page = usePage()
const book = ref(null)

onMounted(async () => {
  try {
    const url = page.url // e.g. "/books/5"
    const id = url.split('/').pop()

    const response = await fetch(`/api/book/show/${id}`)
    book.value = await response.json()
  } catch (e) {
    console.error('Erro ao carregar livro:', e)
  }
})

async function destroy() {
  if (!confirm('Deseja mesmo excluir este livro?')) return

  try {
    await axios.delete(`/api/book/delete/${book.value.id}`)
    router.visit('/books') // redireciona manualmente após sucesso
  } catch (e) {
    console.error('Erro ao excluir livro:', e)
  }
}
</script>

