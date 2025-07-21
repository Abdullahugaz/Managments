<template>
  <AppLayout>
    <Head title="Customers" />

    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Customers</h1>
        <Link href="/customers/create" class="bg-blue-600 text-white px-4 py-2 rounded">Add New</Link>
      </div>

      <table class="w-full border">
        <thead class="bg-gray-200">
          <tr>
            <th class="text-left p-2">#</th>
            <th class="text-left p-2">Name</th>
            <th class="text-left p-2">Email</th>
            <th class="text-left p-2">Phone</th>
            <th class="text-left p-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(customer, index) in customers" :key="customer.id" class="border-t">
            <td class="p-2">{{ index + 1 }}</td>
            <td class="p-2">{{ customer.name }}</td>
            <td class="p-2">{{ customer.email }}</td>
            <td class="p-2">{{ customer.phone }}</td>
            <td class="p-2">
              <Link :href="`/customers/${customer.id}/edit`" class="text-blue-600 hover:underline">Edit</Link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps<{
  customers: Array<{
    id: number;
    name: string;
    email: string;
    phone: string;
  }>;
}>();
</script>
