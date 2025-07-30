<template>
  <div v-if="message" class="p-3 mb-4 bg-green-100 text-green-800 rounded">
    {{ message }}
  </div>
</template>

<script setup>
defineProps({ message: String })
</script>
