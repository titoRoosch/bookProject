<template>
  <div class="min-h-screen bg-gray-100 flex flex-col justify-center items-center text-center p-6">
    <div class="max-w-xl space-y-6">
      <h1 class="text-4xl font-bold text-gray-800">
        Welcome to the Book Management System
      </h1>

      <p class="text-lg text-gray-600">
        This system allows you to manage books and their respective authors efficiently.
        Use the dashboard to add, edit, and view books with ease.
      </p>

      <div class="flex justify-center gap-4">
        <Link
          href="/login"
          class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
        >
          Log In
        </Link>

        <Link
          href="/register"
          class="px-6 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition"
        >
          Register
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
