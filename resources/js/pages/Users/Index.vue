<template>
  <AppLayout>
    <Head title="Users" />
   <div class="p-6 min-h-screen bg-gradient-to-br from-[#e45fed] to-[#5739ed] text-white">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Users</h1>
        <Link :href="route('users.create')"  class="bg-white text-[#7A5FFF] font-semibold px-5 py-2 rounded-full shadow hover:bg-[#fbe6ff] transition">
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
            <td class="p-2">
              <Link
                :href="route('users.edit', user.id)"
                class=" text-[#e10ec2] font-semibold px-5 py-2 rounded-full shadow hover:bg-[#fbe6ff] transition hover:underline"
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
