<template>
  <table class="w-full table-auto border-collapse">
    <thead>
      <tr class="bg-gray-100">
        <th class="border px-4 py-2 text-left">Name</th>
        <th class="border px-4 py-2">Birth Date</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="author in authors" :key="author.id">
        <td class="border px-4 py-2">{{ author.name }}</td>
        <td class="border px-4 py-2">{{ author.birth_date }}</td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
import { storeToRefs } from 'pinia'
import { useAuthorStore } from '../stores/authorStore'

const store = useAuthorStore()
const { authors } = storeToRefs(store) // ⬅️ ESSENCIAL para manter reatividade
</script>
