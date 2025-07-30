<template>
  <div class="overflow-auto rounded-2xl shadow-md bg-white/10 backdrop-blur-sm">
    <table class="w-full min-w-[600px] text-left text-sm text-white">
      <thead class="uppercase text-white/70 border-b border-white/20">
        <tr>
          <th
            v-for="col in columns"
            :key="col.key"
            class="px-4 py-3 text-sm font-medium"
          >
            {{ col.label }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="item in items"
          :key="item.id"
          class="hover:bg-white/10 transition border-b border-white/10"
        >
          <td
            v-for="col in columns"
            :key="col.key"
            class="px-4 py-3 whitespace-nowrap"
          >
            <template v-if="col.key === 'actions'">
              <slot name="actions" :item="item" />
            </template>
            <template v-else>
              {{ item[col.key] }}
            </template>
          </td>
        </tr>
        <tr v-if="!items.length">
          <td
            :colspan="columns.length"
            class="text-center text-white/60 px-4 py-6"
          >
            No data found.
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  columns: Array<{ key: string; label: string }>
  items: Array<Record<string, any>>
}>()
</script>
