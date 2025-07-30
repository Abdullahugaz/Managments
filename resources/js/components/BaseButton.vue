<script setup lang="ts">
defineProps<{
  type?: 'button' | 'submit' | 'reset'
  customClass?: string
  disabled?: boolean
}>()
</script>

<template>
  <button
    :type="type || 'button'"
    :class="[
      'inline-flex items-center justify-center w-full rounded-2xl px-4 py-2 font-semibold transition-colors duration-200',
      'bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2',
      disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
      customClass
    ]"
    :disabled="disabled"
  >
    <slot />
  </button>
</template>
