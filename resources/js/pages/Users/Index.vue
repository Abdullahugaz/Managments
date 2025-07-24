<template>
  <AppLayout>
    <Head title="Users" />
    <div class="p-6 min-h-screen bg-gradient-to-br from-[#e45fed] to-[#5739ed] text-white">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Users</h1>
        <Link
          :href="route('users.create')"
          class="bg-white text-[#7A5FFF] font-semibold px-5 py-2 rounded-full shadow hover:bg-[#fbe6ff] transition"
        >
          Add New User
        </Link>
      </div>

      <table class="w-full table-auto text-white">
        <thead class="bg-[#1A1F3C] text-white">
          <tr>
            <th class="p-2 text-left">#</th>
            <th class="p-2 text-left">Name</th>
            <th class="p-2 text-left">Email</th>
            <th class="p-2 text-left">Phone</th>
            <th class="p-2 text-left">Password (hashed)</th>
            <th class="p-2 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) in users" :key="user.id" class="border-t">
            <td class="p-2">{{ index + 1 }}</td>
            <td class="p-2">{{ user.name }}</td>
            <td class="p-2">{{ user.email }}</td>
            <td class="p-2">{{ user.phone }}</td>
            <td class="p-2 font-mono text-xs break-all">{{ user.password }}</td>
            <td class="p-2 flex space-x-4">
              <Link
                :href="route('users.edit', user.id)"
                class="text-blue-300 hover:underline"
              >
                Edit
              </Link>
              <button
                @click="openDeleteModal(user)"
                class="text-red-300 hover:underline"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Delete Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white text-gray-900 rounded-xl p-6 w-full max-w-md shadow-xl">
        <h2 class="text-xl font-bold mb-4">Confirm Delete</h2>
        <p class="mb-6">
          Are you sure you want to delete user
          <span class="font-semibold text-red-600">"{{ selectedUser?.name }}"</span>?
        </p>
        <div class="flex justify-end space-x-3">
          <button @click="showModal = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
            Cancel
          </button>
          <button @click="deleteUser" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
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
  users: Array<{
    id: number
    name: string
    email: string
    phone: string | null
    password: string
  }>
}>()

const showModal = ref(false)
const selectedUser = ref<{ id: number; name: string } | null>(null)

function openDeleteModal(user: { id: number; name: string }) {
  selectedUser.value = user
  showModal.value = true
}

function deleteUser() {
  if (selectedUser.value) {
    router.delete(route('users.destroy', selectedUser.value.id), {
      onSuccess: () => {
        showModal.value = false
        selectedUser.value = null
      },
    })
  }
}
</script>
