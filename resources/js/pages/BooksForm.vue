<template>
  <div class="p-6 max-w-xl mx-auto">
    <h2 class="text-xl font-semibold mb-4">Register Book</h2>

    <form @submit.prevent="submit">
      <div class="mb-4">
        <label>Title</label>
        <input v-model="form.title" type="text" class="border px-2 py-1 w-full" />
      </div>

      <div class="mb-4">
        <label>Publish Date</label>
        <input v-model="form.published_at" type="date" class="border px-2 py-1 w-full" />
      </div>

      <div class="mb-4">
        <label>Authors</label>
        <AuthorDropdown v-model="form.author_ids" />
      </div>

      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Salvar</button>
    </form>
  </div>
</template>

<script setup>
import { reactive } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import AuthorDropdown from '../components/AuthorDropdown.vue'

const router = useRouter()
const form = reactive({
  title: '',
  published_at: '',
  author_ids: []
})

const submit = async () => {
  try {
    await axios.post('/api/books', form)
    router.push('/books')
  } catch (error) {
    console.error(error)
    alert('Erro ao salvar livro.')
  }
}
</script>
