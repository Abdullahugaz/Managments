<template>
  <AppLayout>
    <Head title="Products" />
    <div class="p-6 min-h-screen bg-gradient-to-br from-[#e45fed] to-[#5739ed] text-white">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Products</h1>
        <Link
          :href="route('products.create')"
          class="bg-white text-[#7A5FFF] font-semibold px-5 py-2 rounded-full shadow hover:bg-[#fbe6ff] transition"
        >
          Add New Product
        </Link>
      </div>

      <table class="w-full table-auto text-white">
        <thead class="bg-[#1A1F3C] text-white">
          <tr>
            <th class="p-2 text-left">#</th>
            <th class="p-2 text-left">Name</th>
            <th class="p-2 text-left">Price</th>
            <th class="p-2 text-left">Stock</th>
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
            <td class="p-2">{{ formatPrice(product.price) }}</td>
            <td class="p-2">{{ product.stock }}</td>
            <td class="p-2 flex space-x-4">
              <Link
                :href="route('products.edit', product.id)"
                class="text-blue-300 hover:underline"
              >
                Edit
              </Link>
              <button
                class="text-red-400 hover:underline"
                @click="openDeleteModal(product)"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Delete Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    >
      <div class="bg-white text-gray-900 rounded-xl p-6 w-full max-w-md shadow-xl">
        <h2 class="text-xl font-bold mb-4">Confirm Delete</h2>
        <p class="mb-6">
          Are you sure you want to delete
          <span class="font-semibold text-red-600">"{{ selectedProduct?.name }}"</span>?
        </p>
        <div class="flex justify-end space-x-3">
          <button
            @click="showModal = false"
            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
          >
            Cancel
          </button>
          <button
            @click="deleteProduct"
            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
          >
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Link, Head, router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

defineProps<{
  products: Array<{
    id: number
    name: string
    price: number | string | null
    stock: number
  }>
}>()

const showModal = ref(false)
const selectedProduct = ref<{ id: number; name: string } | null>(null)

function openDeleteModal(product: { id: number; name: string }) {
  selectedProduct.value = product
  showModal.value = true
}

function deleteProduct() {
  if (selectedProduct.value) {
    router.delete(route('products.destroy', selectedProduct.value.id), {
      onSuccess: () => {
        showModal.value = false
        selectedProduct.value = null
      },
    })
  }
}

function formatPrice(price: number | string | null): string {
  const n = parseFloat(String(price))
  if (isNaN(n)) return '0.00'
  return n.toFixed(2)
}
</script>
