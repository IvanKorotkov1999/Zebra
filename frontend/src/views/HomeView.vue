<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { fetchHealth, type Health } from '../api'

const health = ref<Health | null>(null)
const error = ref('')

onMounted(async () => {
  try {
    health.value = await fetchHealth()
  } catch (e) {
    error.value = e instanceof Error ? e.message : String(e)
  }
})
</script>

<template>
  <main>
    <h1>Zebra</h1>
    <p v-if="health">Backend: {{ health.status }} · PHP {{ health.php }} · DB: {{ health.db }}</p>
    <p v-else-if="error">Backend недоступен: {{ error }}</p>
    <p v-else>Проверяем backend…</p>
  </main>
</template>

<style scoped>
main {
  max-width: 40rem;
  margin: 4rem auto;
  padding: 0 1rem;
  font-family: system-ui, sans-serif;
}
</style>
