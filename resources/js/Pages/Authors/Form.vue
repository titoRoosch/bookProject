<template>
  <div class="max-w-xl mx-auto space-y-6">
    <h1 class="text-2xl font-bold">
      {{ isEdit ? 'Editar Autor' : 'Criar Autor' }}
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
import { ref, reactive, onMounted } from 'vue'
import axios from 'axios'
import { router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

defineOptions({ layout: AuthenticatedLayout })

// Detecta se é edição, capturando o ID da URL
const pathSegments = window.location.pathname.split('/')
const authorId = pathSegments.includes('edit') ? pathSegments[pathSegments.length - 2] : null
const isEdit = !!authorId

const form = reactive({
  name: '',
  birth_date: ''
})

const errors = ref({})

// Se for edição, busca dados do autor via API
onMounted(async () => {
  if (isEdit) {
    try {
      const { data } = await axios.get(`/api/author/show/${authorId}`)
      form.name = data.name
      form.birth_date = data.birth_date
    } catch (err) {
      console.error('Erro ao buscar autor:', err)
    }
  }
})

async function submit() {
  try {
    errors.value = {}

    const payload = {
      name: form.name,
      birth_date: form.birth_date
    }

    if (isEdit) {
      await axios.put(`/api/author/update/${authorId}`, payload)
    } else {
      await axios.post('/api/author/store', payload)
    }

    router.visit('/authors')
  } catch (err) {
    if (err.response && err.response.status === 422) {
      errors.value = err.response.data.errors
    } else {
      console.error('Erro inesperado:', err)
    }
  }
}
</script>
