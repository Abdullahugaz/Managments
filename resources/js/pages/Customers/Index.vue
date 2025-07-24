<template>
  <AppLayout>
    <Head title="Customers" />

    <div class="p-6 min-h-screen bg-gradient-to-br from-[#e45fed] to-[#5739ed] text-white">
      <!-- Flash success message -->
      <div v-if="$page.props.flash?.success" class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ $page.props.flash.success }}
      </div>

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
              <td class="p-3 space-x-2">
                <Link
                  :href="`/customers/${customer.id}/edit`"
                  class="text-[#EC87F3] hover:underline"
                >
                  Edit
                </Link>
                <button
                  @click="openDeleteModal(customer)"
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

    <!-- Delete Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">
      <div class="bg-white rounded-xl p-6 max-w-md w-full shadow-lg text-gray-900">
        <div class="flex items-center space-x-4 mb-4">
          <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M6 18L18 6M6 6l12 12" />
          </svg>
          <h2 class="text-lg font-semibold">Confirm Deletion</h2>
        </div>
        <p class="mb-6">Ma hubtaa inaad tirtirayso <span class="font-semibold text-red-600">{{ selectedCustomer?.name }}</span>?</p>
        <div class="flex justify-end space-x-3">
          <button @click="showModal = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
            Cancel
          </button>
          <button @click="confirmDelete" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
            Delete
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Link, Head, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

// Props
defineProps<{
  customers: Array<{
    id: number;
    name: string;
    email: string;
    phone: string;
  }>;
}>()

const showModal = ref(false)
const selectedCustomer = ref<{ id: number; name: string } | null>(null)

function openDeleteModal(customer: { id: number; name: string }) {
  selectedCustomer.value = customer
  showModal.value = true
}

function confirmDelete() {
  if (selectedCustomer.value) {
    router.delete(`/customers/${selectedCustomer.value.id}`, {
      onSuccess: () => {
        showModal.value = false
        selectedCustomer.value = null
      }
    })
  }
}
</script>
