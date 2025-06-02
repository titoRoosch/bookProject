<template>
  <table class="w-full table-auto border-collapse">
    <thead>
      <tr class="bg-gray-100">
        <th class="border px-4 py-2 text-left cursor-pointer" @click="sortBy('name')">
          Name
          <span v-if="filters.orderBy === 'name'">
            {{ filters.direction === 'asc' ? '↑' : '↓' }}
          </span>
        </th>
        <th class="border px-4 py-2 cursor-pointer" @click="sortBy('birth_date')">
          Birth Date
          <span v-if="filters.orderBy === 'birth_date'">
            {{ filters.direction === 'asc' ? '↑' : '↓' }}
          </span>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="author in authors" :key="author.id" class="hover:bg-gray-50">
        <td class="border px-4 py-2">
          <Link :href="`/authors/${author.id}`" class="text-blue-600 hover:underline">
            {{ author.name }}
          </Link>
        </td>
        <td class="border px-4 py-2">{{ author.birth_date }}</td>
      </tr>
    </tbody>
  </table>

</template>

<script setup>
import { storeToRefs } from 'pinia'
import { useAuthorStore } from '@/stores/authorStore'
import { Link } from '@inertiajs/vue3'

const store = useAuthorStore()
const { authors, filters } = storeToRefs(store)

const sortBy = (field) => {
  if (filters.value.orderBy === field) {
    filters.value.direction = filters.value.direction === 'asc' ? 'desc' : 'asc'
  } else {
    filters.value.orderBy = field
    filters.value.direction = 'asc'
  }
  store.fetchAuthors()
}
</script>
