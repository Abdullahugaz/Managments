<template>
  <div :class="wrapperClass">
    <label v-if="label" class="block mb-1">{{ label }}</label>
    <select
      :value="modelValue"
      @change="onChange"
      class="w-full border px-3 py-2 rounded"
    >
      <option v-for="option in options" :key="option.value" :value="option.value">
        {{ option.label }}
      </option>
    </select>
    <p v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</p>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{
  modelValue: string
  options: { label: string; value: string }[]
  label?: string
  wrapperClass?: string
  error?: string
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>()

function onChange(event: Event) {
  const target = event.target as HTMLSelectElement | null
  if (target) {
    emit('update:modelValue', target.value)
  }
}
</script>
