<template>
  <div :class="wrapperClass">
    <label v-if="label" class="block mb-1">{{ label }}</label>
    <input
      type="date"
      :value="modelValue"
      class="w-full border px-3 py-2 rounded"
      @input="onInput"
    />
    <p v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</p>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{
  modelValue: string
  label?: string
  wrapperClass?: string
  error?: string
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()

function onInput(event: Event) {
  const target = event.target as HTMLInputElement | null
  if (target) {
    emit('update:modelValue', target.value)
  }
}
</script>
