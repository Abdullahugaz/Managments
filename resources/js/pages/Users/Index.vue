<template>
  <AppLayout>
    <Head title="Users" />
    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Users</h1>
        <Link :href="route('users.create')" class="bg-blue-600 text-white px-4 py-2 rounded">
          Add New User
        </Link>
      </div>

      <table class="w-full border bg-white rounded shadow">
        <thead class="bg-gray-200">
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
            <td class="p-2">
              <Link
                :href="route('users.edit', user.id)"
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
  users: Array<{
    id: number
    name: string
    email: string
    phone: string | null
    password: string
  }>
}>()
</script>
