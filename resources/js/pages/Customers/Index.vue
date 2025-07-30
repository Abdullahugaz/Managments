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

      <!-- DataTable -->
      <DataTable :items="customers" :columns="columns">
        <template #actions="{ item }">
          <template v-if="item.status === 'draft'">
            <Link
              :href="`/customers/${item.id}/edit`"
              class="text-[#EC87F3] hover:underline"
            >
              Edit
            </Link>
            <button
              @click="openDeleteModal(item.id)"
              class="text-red-300 hover:underline ml-4"
            >
              Delete
            </button>
          </template>
          <template v-else>
            <Link
              :href="`/customers/${item.id}/edit`"
              class="text-blue-300 hover:underline"
            >
     <img
  src="/images/view-icon.png"
  alt="View"
  class="w-10 h-10 mr-2 invert"
/>

 
  
            </Link>
          </template>
        </template>
      </DataTable>
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
import DataTable from '@/components/DataTable.vue'

defineProps<{
  customers: Array<{
    id: number
    name: string
    email: string
    phone: string
    status: string
    date: string
  }>
}>()

const showModal = ref(false)
const deletingId = ref<number | null>(null)

const columns = [
  { key: 'id', label: '#' },
  { key: 'name', label: 'Name' },
  { key: 'email', label: 'Email' },
  { key: 'phone', label: 'Phone' },
  { key: 'status', label: 'Status' },
  { key: 'date', label: 'Date' },
  { key: 'actions', label: 'Actions' },
]

function openDeleteModal(id: number) {
  deletingId.value = id
  showModal.value = true
}

function cancelDelete() {
  showModal.value = false
  deletingId.value = null
}

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
