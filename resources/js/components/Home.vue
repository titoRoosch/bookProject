<template>
  <div>
    <h1>Welcome to Vue + Laravel</h1>
    <p>Message from backend: {{ message }}</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const message = ref('');

onMounted(async () => {
  const res = await fetch('/api/message');
  const data = await res.json();
  message.value = data.message;
});
</script>