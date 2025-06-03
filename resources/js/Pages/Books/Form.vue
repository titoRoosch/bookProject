<template>
  <div class="max-w-xl mx-auto space-y-6">
    <h1 class="text-2xl font-bold">
      {{ isEdit ? 'Edit Book' : 'Create Book' }}
    </h1>

    <form @submit.prevent="submit">
      <div class="space-y-2">
        <label class="block font-semibold">Title</label>
        <input
          type="text"
          v-model="form.title"
          class="border px-3 py-2 w-full rounded"
        />
        <div v-if="errors.title" class="text-red-500 text-sm">{{ errors.title }}</div>
      </div>

      <div class="space-y-2">
        <label class="block font-semibold">Publish Date</label>
        <input
          type="date"
          v-model="form.publish_date"
          class="border px-3 py-2 w-full rounded"
        />
        <div v-if="errors.publish_date" class="text-red-500 text-sm">{{ errors.publish_date }}</div>
      </div>

      <div class="space-y-2">
        <label class="block font-semibold">Authors</label>
        <AuthorDropdown v-model="form.author_ids" />
        <div v-if="errors.author_ids" class="text-red-500 text-sm">{{ errors.author_ids }}</div>
      </div>

      <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">
        Save
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import axios from 'axios'
import { router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import AuthorDropdown from '@/Components/AuthorDropdown.vue'
axios.defaults.withCredentials = true

defineOptions({ layout: AuthenticatedLayout })

// Extract book ID from URL manually (e.g. /books/5/edit)
const pathSegments = window.location.pathname.split('/')
const bookId = pathSegments.includes('edit') ? pathSegments[pathSegments.length - 2] : null

const isEdit = !!bookId

const form = reactive({
  title: '',
  publish_date: '',
  author_ids: []
})

const errors = reactive({
  title: '',
  publish_date: '',
  author_ids: ''
})

// Fetch existing book if editing
onMounted(async () => {
  if (bookId) {
    try {
      const { data } = await axios.get(`/api/book/show/${bookId}`)
      form.title = data.title
      form.publish_date = data.publish_date
      form.author_ids = data.authors.map(a => a.id)
    } catch (err) {
      console.error('Failed to fetch book:', err)
    }
  }
})

function validateForm() {
  errors.title = ''
  errors.publish_date = ''

  if (!form.title.trim()) {
    errors.title = 'Title is required'
  }

  if (!form.publish_date) {
    errors.publish_date = 'Publish date is required'
  } else if (new Date(form.publish_date) > new Date()) {
    errors.publish_date = 'Publish date cannot be in the future'
  }

  return !errors.title && !errors.publish_date
}

async function submit() {
  try {
    errors.value = {}

    if (!validateForm()) return

    const payload = {
      title: form.title,
      publish_date: form.publish_date,
      authors: form.author_ids.map(id => ({ author_id: id }))
    }

    if (isEdit) {
      await axios.put(`/api/book/update/${bookId}`, payload)
    } else {
      await axios.post('/api/book/store', payload)
    }

    router.visit('/books')
  } catch (err) {
    if (err.response && err.response.status === 422) {
      errors.value = err.response.data.errors
    } else {
      console.error('Unexpected error:', err)
    }
  }
}
</script>
