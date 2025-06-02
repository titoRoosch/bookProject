<template>
  <div class="p-6 space-y-8">
    <h1 class="text-2xl font-bold mb-4">Dashboard 📊</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-lg font-semibold mb-2">Books by Year</h2>
        <canvas id="booksYearChart"></canvas>
      </div>

      <div class="bg-white p-4 rounded shadow">
        <h2 class="text-lg font-semibold mb-2">Top Authors</h2>
        <canvas id="booksAuthorChart"></canvas>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import Chart from 'chart.js/auto'

onMounted(async () => {
  const res = await fetch('/api/dashboard')
  const data = await res.json()

  const anoCtx = document.getElementById('booksYearChart')
  new Chart(anoCtx, {
    type: 'bar',
    data: {
      labels: data.books_by_year.map(item => item.year),
      datasets: [{
        label: 'Quantidade',
        data: data.books_by_year.map(item => item.total),
        backgroundColor: '#4f46e5'
      }]
    },
    options: { responsive: true }
  })

  const autorCtx = document.getElementById('booksAuthorChart')
  new Chart(autorCtx, {
    type: 'doughnut',
    data: {
      labels: data.books_by_author.map(item => item.name),
      datasets: [{
        label: 'Livros',
        data: data.books_by_author.map(item => item.books_count),
        backgroundColor: ['#4f46e5', '#22c55e', '#f59e0b', '#ef4444', '#0ea5e9']
      }]
    },
    options: { responsive: true }
  })
})
</script>
