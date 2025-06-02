<template>
  <table class="w-full table-auto border-collapse">
    <thead>
      <tr class="bg-gray-100">
        <th class="border px-4 py-2 text-left">Name</th>
        <th class="border px-4 py-2">Birth Date</th>
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
const { authors } = storeToRefs(store)
</script>
