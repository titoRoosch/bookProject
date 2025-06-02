<template>
  <div class="max-w-xl mx-auto space-y-6">
    <h1 class="text-2xl font-bold">
      {{ author?.id ? 'Editar Autor' : 'Criar Autor' }}
    </h1>

    <form @submit.prevent="submit">
      <div class="space-y-2">
        <label class="block font-semibold">Nome</label>
        <input
          type="text"
          v-model="form.name"
          class="border px-3 py-2 w-full rounded"
        />
        <div v-if="errors.name" class="text-red-500 text-sm">
          {{ errors.name }}
        </div>
      </div>

      <div class="space-y-2">
        <label class="block font-semibold">Data de nascimento</label>
        <input
          type="date"
          v-model="form.birth_date"
          class="border px-3 py-2 w-full rounded"
        />
        <div v-if="errors.birth_date" class="text-red-500 text-sm">
          {{ errors.birth_date }}
        </div>
      </div>

      <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">
        Salvar
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import axios from 'axios'
import { usePage, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import AuthorDropdown from '@/Components/AuthorDropdown.vue'

defineOptions({ layout: AuthenticatedLayout })

const page = usePage()
const author = page.props.author ?? null

const form = reactive({
  name: author?.name || '',
  birth_date: author?.birth_date || '',
})

const errors = ref({})

async function submit() {
  try {
    errors.value = {}

    const payload = {
      name: form.name,
      birth_date: form.birth_date,
    }

    if (author?.id) {
      await axios.put(`/api/author/update/${author.id}`, payload)
    } else {
      await axios.post('/api/author/store', payload)
    }

    router.visit('/authors')
  } catch (err) {
    if (err.response && err.response.status === 422) {
      errors.value = err.response.data.errors
    } else {
      console.error('Unexpected error:', err)
    }
  }
}
</script>
