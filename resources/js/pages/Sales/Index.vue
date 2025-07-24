<template>
  <AppLayout>
    <Head title="Sales" />

    <div class="p-6 min-h-screen bg-gradient-to-br from-[#e45fed] to-[#5739ed] text-white">
      <!-- Title + Create Button -->
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Sales</h1>
        <Link href="/sales/create" class="bg-white text-[#7A5FFF] font-semibold px-5 py-2 rounded-full shadow hover:bg-[#fbe6ff] transition">
          New Sale
        </Link>
      </div>

      <!-- Sales Table -->
      <div class="overflow-x-auto">
        <table class="w-full table-auto text-white">
          <thead class="bg-[#1A1F3C] text-white">
            <tr class="text-left">
              <th class="p-2">Customer</th>
              <th class="p-2">Product</th>
              <th class="p-2">Quantity</th>
              <th class="p-2">Total</th>
              <th class="p-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="sale in sales" :key="sale.id" class="border-t hover:bg-white/10">
              <td class="p-2">{{ sale.customer.name }}</td>
              <td class="p-2">{{ sale.product.name }}</td>
              <td class="p-2">{{ sale.quantity }}</td>
              <td class="p-2">${{ sale.total_price }}</td>
              <td class="p-2 flex space-x-4">
                <Link :href="`/sales/${sale.id}/edit`" class="text-blue-300 hover:underline">Edit</Link>
                <button @click="openDeleteModal(sale)" class="text-red-300 hover:underline">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white text-gray-900 rounded-xl p-6 w-full max-w-md shadow-xl">
        <h2 class="text-xl font-bold mb-4">Confirm Delete</h2>
        <p class="mb-6">
          Are you sure you want to delete sale for
          <span class="font-semibold text-red-600">"{{ selectedSale?.customer.name }}"</span>?
        </p>
        <div class="flex justify-end space-x-3">
          <button @click="showModal = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
            Cancel
          </button>
          <button @click="deleteSale" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
            Yes, Delete
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref } from 'vue'

const props = defineProps({ sales: Array })

const showModal = ref(false)
const selectedSale = ref(null)

function openDeleteModal(sale) {
  selectedSale.value = sale
  showModal.value = true
}

function deleteSale() {
  if (selectedSale.value) {
    router.delete(`/sales/${selectedSale.value.id}`, {
      onSuccess: () => {
        showModal.value = false
        selectedSale.value = null
      }
    })
  }
}
</script>
