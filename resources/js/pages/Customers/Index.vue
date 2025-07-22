<template>
  <AppLayout>
    <Head title="Customers" />

    <div class="p-6 min-h-screen bg-gradient-to-br from-[#e45fed] to-[#5739ed] text-white">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white drop-shadow">Customers</h1>
        <Link
          href="/customers/create"
          class="bg-white text-[#7A5FFF] font-semibold px-5 py-2 rounded-full shadow hover:bg-[#fbe6ff] transition"
        >
          + Add Customer
        </Link>
      </div>

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
              <td class="p-3">
                <Link
                  :href="`/customers/${customer.id}/edit`"
                  class="text-[#EC87F3] hover:underline"
                >
                  Edit
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
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
}>()
</script>
