<template>
  <table class="w-full table-auto border-collapse">
    <thead>
      <tr class="bg-gray-100">
        <th class="border px-4 py-2 text-left">Título</th>
        <th class="border px-4 py-2">Data de publicação</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="book in books" :key="book.id" class="hover:bg-gray-50">
        <td class="border px-4 py-2">
          <Link :href="`/books/${book.id}`" class="text-blue-600 hover:underline">
            {{ book.title }}
          </Link>
        </td>
        <td class="border px-4 py-2">{{ book.publish_date }}</td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
import { storeToRefs } from 'pinia'
import { useBookStore } from '@/stores/bookStore'
import { Link } from '@inertiajs/vue3'

const store = useBookStore()
const { books } = storeToRefs(store)
</script>
