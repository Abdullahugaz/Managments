<template>
  <AppLayout>
    <Head title="Products" />
    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Products</h1>
        <Link
          :href="route('products.create')"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          Add New Product
        </Link>
      </div>

      <table class="w-full border bg-white rounded shadow">
        <thead class="bg-gray-200">
          <tr>
            <th class="p-2 text-left">#</th>
            <th class="p-2 text-left">Name</th>
            <th class="p-2 text-left">Price</th>
            <th class="p-2 text-left">Stock</th>  <!-- Added this -->
            <th class="p-2 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(product, index) in products"
            :key="product.id"
            class="border-t"
          >
            <td class="p-2">{{ index + 1 }}</td>
            <td class="p-2">{{ product.name }}</td>
            <td class="p-2">
              {{ formatPrice(product.price) }}
            </td>
            <td class="p-2">{{ product.stock }}</td>  <!-- Added this -->
            <td class="p-2">
              <Link
                :href="route('products.edit', product.id)"
                class="text-blue-600 hover:underline"
              >
                Edit
              </Link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

defineProps<{
  products: Array<{
    id: number
    name: string
    price: number | string | null
    stock: number      // make sure stock is included in props
  }>
}>()

// Format price safely to always show 2 decimals
function formatPrice(price: number | string | null): string {
  const n = parseFloat(String(price))
  if (isNaN(n)) return '0.00'
  return n.toFixed(2)
}
</script>
