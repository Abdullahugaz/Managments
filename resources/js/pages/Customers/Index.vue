<template>
  <AppLayout>
    <Head title="Customers" />

    <div class="p-6 min-h-screen bg-gradient-to-br from-[#e45fed] to-[#5739ed] text-white">
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white drop-shadow">Customers</h1>
        <Link
          href="/customers/create"
          class="bg-white text-[#7A5FFF] font-semibold px-5 py-2 rounded-full shadow hover:bg-[#fbe6ff] transition"
        >
          + Add Customer
        </Link>
      </div>

      <!-- Table -->
      <div class="overflow-auto rounded-xl shadow-lg bg-[#1A0D80]/30 backdrop-blur p-4">
        <table class="w-full table-auto text-white">
          <thead class="text-left border-b border-white/20">
            <tr>
              <th class="p-3">#</th>
              <th class="p-3">Name</th>
              <th class="p-3">Email</th>
              <th class="p-3">Phone</th>
              <th class="p-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(customer, index) in customers"
              :key="customer.id"
              class="hover:bg-white/10 transition"
            >
              <td class="p-3">{{ index + 1 }}</td>
              <td class="p-3">{{ customer.name }}</td>
              <td class="p-3">{{ customer.email }}</td>
              <td class="p-3">{{ customer.phone }}</td>
              <td class="p-3 flex gap-4">
                <Link
                  :href="`/customers/${customer.id}/edit`"
                  class="text-[#EC87F3] hover:underline"
                >
                  Edit
                </Link>
                <button
                  @click="openDeleteModal(customer.id)"
                  class="text-red-300 hover:underline"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    >
      <div class="bg-white text-black rounded-lg shadow-xl p-6 w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Delete Customer</h2>
        <p>Are you sure you want to delete this customer?</p>
        <div class="mt-6 flex justify-end gap-4">
          <button
            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
            @click="cancelDelete"
          >
            Cancel
          </button>
          <button
            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
            @click="confirmDelete"
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
import { router, Link, Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

// Props from server
defineProps<{
  customers: Array<{
    id: number
    name: string
    email: string
    phone: string
  }>
}>()

// Modal state
const showModal = ref(false)
const deletingId = ref<number | null>(null)

// Open modal
function openDeleteModal(id: number) {
  deletingId.value = id
  showModal.value = true
}

// Cancel delete
function cancelDelete() {
  showModal.value = false
  deletingId.value = null
}

// Confirm delete
function confirmDelete() {
  if (deletingId.value !== null) {
    router.delete(`/customers/${deletingId.value}`, {
      onSuccess: () => {
        showModal.value = false
        deletingId.value = null
      },
      onError: (errors) => {
        console.error('Delete failed:', errors)
      },
    })
  }
}
</script>
