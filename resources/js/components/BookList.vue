<template>
  <table class="w-full table-auto border-collapse">
    <thead>
      <tr class="bg-gray-100">
        <th class="border px-4 py-2 text-left">Título</th>
        <!-- <th class="border px-4 py-2">Autor</th> -->
        <th class="border px-4 py-2">Publicado em</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="book in books" :key="book.id">
        <td class="border px-4 py-2">{{ book.title }}</td>
        <!-- <td class="border px-4 py-2">{{ book.author?.name }}</td> -->
        <td class="border px-4 py-2">{{ book.publish_date }}</td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
import { storeToRefs } from 'pinia'
import { useBookStore } from '../stores/bookStore'

const store = useBookStore()
const { books } = storeToRefs(store) // ⬅️ ESSENCIAL para manter reatividade
</script>
